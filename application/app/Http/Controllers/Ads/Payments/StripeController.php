<?php

namespace App\Http\Controllers\Ads\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Stripe;
use App\Models\Ad;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAdPayment;
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
	public function get(Request $request, $ad_id)
	{
		// Get user id
        $user_id = Auth::id();
        
        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if ($ad) {

			// Check if gateway is enabled
			if (!Helper::settings_payments()->is_stripe) {
				
				// Not enabled
				return redirect('account/ads/upgrade/'.$ad_id)->with('error', __('update.lang_gateway_not_enabled'));

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

			return view($this->theme.'.account.ads.checkout.stripe', compact('ad'));

		}else{
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
        }
	}

	/**
	 * Checkout
	 */	
	public function post(Request $request, $ad_id)
	{
		// Get user id
        $user_id = Auth::id();
        
        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if ($ad) {

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

				// Days must greater than week
				if ($days < 7) {
					// Error
					return redirect('account/ads/'.$ad_id.'/checkout/stripe')->with('error', 'Oops! Days must be greater than week');
				}
				
				// Set Total price
				$total_price = $days * config('services.stripe.ad_price');

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
						$ends_at = Carbon::now()->addDays($days);

						// Payment Success, Create new ad payment
				    	$setPayment = DB::table('ads_payments')->insertGetId([
							'user_id'        => Auth::id(),
							'ad_id'          => $ad_id,
							'days'           => $days,
							'brand'          => 'stripe',
							'transaction_id' => $charge['balance_transaction'],
							'card_number'    => $number,
							'exp_year'       => $expiryYear,
							'exp_month'      => $expiryMonth,
							'cvv'            => $cvv,
							'card_last_four' => $charge['source']['last4'],
							'amount'         => $total_price,
							'currency'       => $currency,
							'is_accepted'    => NULL,
							'ends_at'        => $ends_at,
							'created_at'     => Carbon::now(),
							'updated_at'     => Carbon::now(),
						]);

						// Send Admin Notification
						$admin = User::where('is_admin', 1)->where('id', 1)->first();
						$admin->notify(new NewAdPayment([
							'ad_id'          => $ad_id,		
							'method'         => 'stripe',		
							'type'           => 'ad',		
							'transaction_id' => $charge['balance_transaction'],		
							'user_id'        => Auth::id()
						]));

						// Add Payment Notification to databse
						DB::table('notifications_payments')->insert([
							'user_id'          => Auth::id(),
							'payment_id'       => $setPayment,
							'transaction_id'   => $charge['balance_transaction'],
							'payment_method'   => 'stripe',
							'payment_type'     => 'ad',
							'payment_amount'   => $total_price,
							'payment_currency' => $currency,
							'created_at'       => Carbon::now(),
							'updated_at'       => Carbon::now(),
						]);

						// Return Success
				    	return redirect('account/ads/'.$ad_id.'/checkout/stripe')->with('success', __('return/success.lang_payment_success'));

					}else{

						// Payment Failed
						return redirect('account/ads/'.$ad_id.'/checkout/stripe')->with('error', __('return/error.lang_payment_failed'));

					}

				} catch (\Exception $e) {
					
					// Error
					return redirect('account/ads/'.$ad_id.'/checkout/stripe')->with('error', 'Oops! '.$e->getMessage());

				}
				

			}else{

				// Error
				return redirect('checkout/stripe')->withErrors($validator);

			}

		}else{
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
        }
		
	}

}