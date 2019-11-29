<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Stripe;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAccountPayment;
use DB;
use App\User;
use Helper;
use SEOMeta;
use SEO;
use Protocol;
use Theme;

/**
 * StripeController
 */

class StripeController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Pay with Stripe
	 */
	public function get()
	{
		// Check if gateway is enabled
		if (!Helper::settings_payments()->is_stripe) {
			
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

		return view($this->theme.'.checkout.stripe');
	}

	/**
	 * Checkout
	 */	
	public function post(Request $request)
	{
		// Make Rules
		$rules = array(
			'days'        => 'required|numeric', 
			'number'      => 'required|numeric', 
			'expiryYear'  => 'required|numeric', 
			'expiryMonth' => 'required|numeric', 
			'cvv'         => 'required|numeric',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {

			// Get inputs values
			$number      = $request->get('number');
			$expiryYear  = $request->get('expiryYear');
			$expiryMonth = $request->get('expiryMonth');
			$cvv         = $request->get('cvv');
			$days        = $request->get('days');

			// Days must be between 10 and 5000 days
			if ($days < 10) {
				// Error
				return redirect('checkout/stripe')->with('error', 'Oops! Days must be greater than 10 days');
			}
			
			// Set Total price
			$total_price = $days * config('services.stripe.account_price');

			// Set Currency
			$currency = config('services.stripe.currency');

			try {
				
				$stripe      = Stripe::make(config('services.stripe.secret'));
			
				// Create new customer
				$customer    = Stripe::customers()->create([
				'email'      => Auth::user()->email,
				]);
				
				$token       = Stripe::tokens()->create([
				'card'       => [
					'number'     => $number,
					'exp_month'  => $expiryMonth,
					'cvc'        => $cvv,
					'exp_year'   => $expiryYear,
				],
				]);
				
				$card        = Stripe::cards()->create($customer['id'], $token['id']);
				
				$charge      = Stripe::charges()->create([
				'customer'   => $customer['id'],
				'currency'   => $currency,
				'amount'     => $total_price,
				]);

				// Check payment Status
				if ($charge['status'] == 'succeeded') {
					
					// Set Expire Date
					$ends_at                       = Carbon::now()->addDays($days);
					
					// Payment Success, Create new Subscription
					$subscription                 = new Subscription;
					$subscription->user_id        = Auth::id();
					$subscription->days           = $days;
					$subscription->brand          = 'stripe';
					$subscription->transaction_id = $charge['balance_transaction'];
					$subscription->card_number    = $number;
					$subscription->exp_year       = $expiryYear;
					$subscription->exp_month      = $expiryMonth;
					$subscription->cvv            = $cvv;
					$subscription->card_last_four = $charge['source']['last4'];
					$subscription->amount         = $total_price;
					$subscription->currency       = $currency;
					$subscription->is_accepted    = NULL;
					$subscription->ends_at        = $ends_at;
					$subscription->save();

					// Send Admin Notification
					$admin = User::where('is_admin', 1)->where('id', 1)->first();
					$admin->notify(new NewAccountPayment([
						'user_id'        => Auth::id(),		
						'method'         => 'stripe',		
						'type'           => 'account',		
						'transaction_id' => $charge['balance_transaction'],		
						'user_id'        => Auth::id()
					]));

					// Add Payment Notification to databse
					DB::table('notifications_payments')->insert([
						'user_id'          => Auth::id(),
						'payment_id'       => $subscription->id,
						'transaction_id'   => $charge['balance_transaction'],
						'payment_method'   => 'stripe',
						'payment_type'     => 'account',
						'payment_amount'   => $total_price,
						'payment_currency' => $currency,
						'created_at'       => Carbon::now(),
						'updated_at'       => Carbon::now(),
					]);

					// Return Success
			    	return redirect('checkout/stripe')->with('success', __('return/success.lang_payment_success'));

				}else{

					// Payment Failed
					return redirect('checkout/stripe')->with('error', __('return/error.lang_payment_failed'));

				}

			} catch (\Exception $e) {
				
				// Error
				return redirect('checkout/stripe')->with('error', 'Oops! '.$e->getMessage());

			}
			

		}else{

			// Error
			return redirect('checkout/stripe')->withErrors($validator);

		}
		
	}

}