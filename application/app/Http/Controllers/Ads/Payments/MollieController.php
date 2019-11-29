<?php

namespace App\Http\Controllers\Ads\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Mollie;
use App\Models\Subscription;
use App\Models\Ad;
use App\Notifications\Payments\Admin\NewAdPayment;
use DB;
use App\User;
use Protocol;
use Session;
use Helper;
use SEOMeta;
use SEO;
use Theme;

/**
 * MollieController
 */

class MollieController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Pay with Mollie
	 */
	public function get(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();
		
		// Check if ad exists
		$ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {

			// Check if gateway is enabled
			if (!Helper::settings_payments()->is_mollie) {
				
				// Not enabled
				return redirect('account/ads/upgrade/'.$ad_id)->with('error', __('update.lang_gateway_not_enabled'));

			}

			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle(__('update.lang_mollie_checkout').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			return view($this->theme.'.account.ads.checkout.mollie', compact('ad'));

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
				'days'        => 'required|numeric'
			);

			// Make Validation
			$validator = Validator::make($request->all(), $rules);

			if ($validator->passes()) {

				// Get inputs values
				$days        = $request->get('days');

				// Days must be at less a week
				if ($days < 7) {
					// Error
					return redirect('account/ads/'.$ad_id.'/checkout/mollie')->with('error', 'Oops! Days must be greater than week');
				}
				
				// Set Total price
				$total_price = $days * config('services.mollie.ad_price');

				// Set Currency
				$currency = config('services.mollie.currency');

				try {
					
					$payment = Mollie::api()->payments()->create([
					    "amount"      => $total_price,
					    "description" => "Upgrade Your Account!",
					    "redirectUrl" => Protocol::home()."/account/ads/".$ad_id."/checkout/mollie/callback",
					]);

					// Put days in session
					Session::put('mollie_payment_id', $payment->id);
					Session::put('ad_upgrade_days', $days);

					// Redirect to payment page
					return redirect($payment->links->paymentUrl);

				} catch (\Exception $e) {
					
					// Error
					return redirect('account/ads/'.$ad_id.'/checkout/mollie')->with('error', 'Oops! '.$e->getMessage());

				}
				

			}else{

				// Error
				return redirect('account/ads/'.$ad_id.'/checkout/mollie')->withErrors($validator);

			}

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
		
	}

	public function callback(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();
		
		// Check if ad exists
		$ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {

			// Get Payment ID
			$payment_id = Session::get('mollie_payment_id');
			
			$payment    = Mollie::api()->payments()->get($payment_id);

			if ($payment->isPaid()){

				// Get Default Payment Currency
				$currency         = config('services.mollie.currency');
				
				// Get days
				$days             = Session::get('ad_upgrade_days');
				
				// Get Total Price
				$total_price      = $days * config('services.mollie.ad_price');
				
				// Set Expire date
				$ends_at          = Carbon::now()->addDays($days);

				// Payment Success, Create new ad payment
		    	$setPayment = DB::table('ads_payments')->insertGetId([
					'user_id'        => Auth::id(),
					'ad_id'          => $ad_id,
					'days'           => $days,
					'brand'          => 'mollie',
					'transaction_id' => $payment_id,
					'card_number'    => NULL,
					'exp_year'       => NULL,
					'exp_month'      => NULL,
					'cvv'            => NULL,
					'card_last_four' => NULL,
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
					'method'         => 'mollie',		
					'type'           => 'ad',		
					'transaction_id' => $payment_id,		
					'user_id'        => Auth::id()
				]));

				// Add Payment Notification to databse
				DB::table('notifications_payments')->insert([
					'user_id'          => Auth::id(),
					'payment_id'       => $setPayment,
					'transaction_id'   => $payment_id,
					'payment_method'   => 'mollie',
					'payment_type'     => 'ad',
					'payment_amount'   => $total_price,
					'payment_currency' => $currency,
					'created_at'       => Carbon::now(),
					'updated_at'       => Carbon::now(),
				]);

				// Delete Session values
                Session::forget('ad_upgrade_days');
                Session::forget('mollie_payment_id');

				// Thank the user for the upgrade
				return redirect('account/ads/'.$ad_id.'/checkout/mollie')->with('success', __('return/success.lang_payment_success'));

			}else{

				// Payment Failed
				return redirect('account/ads/'.$ad_id.'/checkout/mollie')->with('error', __('return/error.lang_payment_failed'));

			}

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}

	}

}