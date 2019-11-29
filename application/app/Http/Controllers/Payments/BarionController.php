<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LaravelHungary\Barion\Enums\Currency;
use LaravelHungary\Barion\Enums\PaymentType;
use LaravelHungary\Barion\Enums\Locale;
use LaravelHungary\Barion\Enums\FundingSource;
use App\Notifications\Payments\Admin\NewAccountPayment;
use App\Models\Subscription;
use App\User;
use Carbon\Carbon;
use Barion;
use Theme;
use Protocol;
use Helper;
use SEO;
use SEOMeta;
use Validator;
use Auth;
use DB;

class BarionController extends Controller
{

	public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

    /**
    * Pay using Barion
    */
    public function get()
	{
		// Check if gateway is enabled
		if (!Helper::settings_payments()->is_barion) {
			
			// Not enabled
			return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

		}

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('update_three.lang_barion_checkout').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.checkout.barion');
	}

    /**
    * Manage payment
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

			// Get upgrade days
	    	$days = $request->get('days');

			// Days must be between 10 and 5000 days
			if ($days < 10) {
				// Error
				return redirect('checkout/barion')->with('error', 'Oops! Days must be greater than 10 days');
			}

			// Set Total price
			$total_price = $days * config('services.barion.account_price');

	    	// Handle new payment
	    	$payment = Barion::paymentStart([
				'PaymentType'    => PaymentType::IMMEDIATE,
				'GuestCheckOut'  => true,
				'FundingSources' => [FundingSource::ALL],
				'Locale'         => Locale::HU,
				'Currency'       => Currency::HUF,
				'Transactions'   => [
			        [
						'POSTransactionId' => str_random(15),
						'Payee'            => Auth::user()->email,
						'Total'            => $total_price,
						'Items'            => [
			                [
								'Name'        => 'Upgrade Account',
								'Description' => 'Upgrade your acount now',
								'Quantity'    => 1,
								'Unit'        => 'db',
								'UnitPrice'   => $total_price,
								'ItemTotal'   => $total_price
			                ]
			            ]
			         ]
			    ]
			]);

			// Redirect to payment page
			return redirect($payment->GatewayUrl);

		}else{

			// Error
			return redirect('checkout/barion')->withErrors($validator);

		}
    }

    /**
	* Get Payment response
    */
    public function callback(Request $request)
    {
    	// Get payment id
    	$paymentId = $request->get('paymentId');

    	// Check payment
    	$payment = Barion::getPaymentState($paymentId);

    	// check if payment success
    	if ($payment->Status == 'Succeeded') {

			// Get Default Payment Currency
			$currency    = 'HUF';
			
			// Get days
			$total_price = $payment->Transactions[0]->Total;
			
			// Get Total Price
			$days        = $total_price / config('services.barion.account_price');
			
			// Set Expire date
			$ends_at     = Carbon::now()->addDays($days);

	    	// Payment Success, Create new Subscription
			$subscription                 = new Subscription;
			$subscription->user_id        = Auth::id();
			$subscription->days           = $days;
			$subscription->brand          = 'barion';
			$subscription->transaction_id = $payment->PaymentId;
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
				'method'         => 'barion',		
				'type'           => 'account',		
				'transaction_id' => $paymentId,		
				'user_id'        => Auth::id()
			]));

			// Add Payment Notification to databse
			DB::table('notifications_payments')->insert([
				'user_id'          => Auth::id(),
				'payment_id'       => $subscription->id,
				'transaction_id'   => $paymentId,
				'payment_method'   => 'barion',
				'payment_type'     => 'account',
				'payment_amount'   => $total_price,
				'payment_currency' => $currency,
				'created_at'       => Carbon::now(),
				'updated_at'       => Carbon::now(),
			]);

			// Thank the user for the upgrade
			return redirect('/checkout/barion')->with('success', __('return/success.lang_payment_success'));

		}else{

    		// Payment Failed
    		return redirect('/checkout/barion')->with('error', __('return/error.lang_payment_failed'));

    	}
    }
}
