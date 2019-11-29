<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use PaytmWallet;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAccountPayment;
use DB;
use App\User;
use Helper;
use SEOMeta;
use SEO;
use Protocol;
use Theme;

class PaytmController extends Controller
{
    
	public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Start new payment using Paytm service
	 * @return string payment page
	 */			
	public function get()
	{
		// Check if gateway is enabled
		if (!Helper::settings_payments()->is_paytm) {
			
			// Not enabled
			return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

		}

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('update.lang_stripe_checkout').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.checkout.paytm');
	}

	/**
	 * Progress payment 
	 * @param  Request $request Get request
	 * @return function           Redirect
	 */
	public function post(Request $request)
	{
		
		// Make Rules
		$rules = array(
			'days'        => 'required|numeric'
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {

			// Get inputs values
			$days        = $request->get('days');

			// Days must be between 10 and 5000 days
			if ($days < 7) {
				// Error
				return redirect('checkout/paytm')->with('error', 'Oops! Days must be greater than 7 days');
			}
			
			// Set Total price
			$total_price = $days * config('services.paytm-wallet.account_price');

			try {

				// Fake data
				$faker = \Faker\Factory::create();
				$faker->addProvider(new \Faker\Provider\ne_NP\PhoneNumber($faker));

				// Generate payment details
				$email   = Auth::user()->email;
				$amount  = $total_price;
				$phone   = $faker->tollFreePhoneNumber;
				$user_id = Auth::id();
				
				$payment = PaytmWallet::with('receive');
		        $payment->prepare([
					'order'         => str_random(15),
					'user'          => $user_id,
					'mobile_number' => $phone,
					'email'         => $email,
					'amount'        => $total_price,
					'callback_url'  => 'http://www.only4pets.com'
		        ]);

		        return $payment->receive();
				
			} catch (\Exception $e) {

				// Error
				return redirect('checkout/paytm')->with('error', $e->getMessage());

			}

		}else{

			// Error
			return redirect('checkout/paytm')->withErrors($validator);

		}
		
	}


	/**
	 * Get payment status
	 * @return function redirect
	 */
	public function callback()
    {
		$transaction = PaytmWallet::with('receive');
		
		$response    = $transaction->response();
        
        if($transaction->isSuccessful()){
          
          	// Successfull payment, Get Payment Currency
			$currency    = $response->CURRENCY;
			
			// Get days
			$total_price = $response->TXNAMOUNT;
			
			// Get Total Price
			$days        = $total_price / config('services.paytm-wallet.account_price');
			
			// Set Expire date
			$ends_at     = Carbon::now()->addDays($days);

	    	// Payment Success, Create new Subscription
			$subscription                 = new Subscription;
			$subscription->user_id        = Auth::id();
			$subscription->days           = $days;
			$subscription->brand          = 'paytm';
			$subscription->transaction_id = $transaction->getOrderId();
			$subscription->card_number    = NULL;
			$subscription->exp_year       = NULL;
			$subscription->exp_month      = NULL;
			$subscription->cvv            = NULL;
			$subscription->card_last_four = NULL;
			$subscription->amount         = $total_price;
			$subscription->currency       = $currency;
			$subscription->is_accepted    = NULL;
			$subscription->ends_at        = $ends_at;
	    	$subscription->save();

	    	// Send Admin Notification
			$admin = User::where('is_admin', 1)->where('id', 1)->first();

			$admin->notify(new NewAccountPayment([
				'user_id'        => Auth::id(),
				'method'         => 'paytm',		
				'type'           => 'account',		
				'transaction_id' => $transaction->getOrderId(),		
				'user_id'        => Auth::id()
			]));

			// Add Payment Notification to databse
			DB::table('notifications_payments')->insert([
				'user_id'          => Auth::id(),
				'payment_id'       => $subscription->id,
				'transaction_id'   => $transaction->getOrderId(),
				'payment_method'   => 'paytm',
				'payment_type'     => 'account',
				'payment_amount'   => $total_price,
				'payment_currency' => $currency,
				'created_at'       => Carbon::now(),
				'updated_at'       => Carbon::now(),
			]);

			// Thank the user for the upgrade
			return redirect('/checkout/paytm')->with('success', __('return/success.lang_payment_success'));

        }else if($transaction->isFailed()){
          
          	// Payment Failed
    		return redirect('/checkout/paytm')->with('error', __('return/error.lang_payment_failed'));

        }else if($transaction->isOpen()){
          	
          	// Payment Failed
    		return redirect('/checkout/paytm')->with('error', __('return/error.lang_payment_failed'));

        }
    } 

}
