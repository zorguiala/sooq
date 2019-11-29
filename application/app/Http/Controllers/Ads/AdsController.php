<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\Payments\Admin\NewAdPayment;
use Auth;
use DB;
use App\User;
use App\Models\Ad;
use App\Models\Stats;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Charts;
use Helper;
use SEO;
use SEOMeta;
use Protocol;
use Carbon\Carbon;
use PayPal;
use Twocheckout;
use Twocheckout_Error;
use Twocheckout_Charge;
use Validator;
use Session;
use Redirect;
use Uploader;
use Lang;
use Theme;

/**
* AdsController
*/
class AdsController extends Controller
{
    public $theme = '';
	
	private $_apiContext;

	function __construct()
	{
		$this->middleware('auth');
		$this->theme = Theme::get();

		$this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));
		
		$this->_apiContext->setConfig(array(
			'mode'                   => 'sandbox',
			'service.EndPoint'       => 'https://api.sandbox.paypal.com',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled'         => true,
			'log.FileName'           => storage_path('logs/paypal.log'),
			'log.LogLevel'           => 'FINE'
		));
	}


	/**
	 * My Ads
	 */
	public function myads()
	{
		// Get user id
		$user_id = Auth::id();

		// Get user ads
		$ads     = Ad::where('user_id', $user_id)->where('is_trashed', 0)->orderBy('id', 'desc')->paginate(10);

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_my_advertisements').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.myads')->with('ads', $ads);
	}

	/**
	 * Upgrade Ad
	 */
	public function upgrade(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check if ad exists
		$ad = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {
				
			// Get Membership settings
			$settings = Helper::settings_payments();
			
			// Send data
			$data     = array(
				'ad'       => $ad, 
				'settings' => $settings, 
			);

			// Get Tilte && Description
			$title      = Helper::settings_general()->title;
			$long_desc  = Helper::settings_seo()->description;
			$keywords   = Helper::settings_seo()->keywords;

			// Manage SEO
			SEO::setTitle(__('title.lang_upgrade_ad').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			// Upgrade Ad
			return view($this->theme.'.account.ads.upgrade')->with($data);

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

	/**
	 * Upgrade Ad Checkout
	 */
	public function checkout(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check if ad exists
		$ad = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {
				
			// Make Rules
			$rules = array(
				'method'               => 'required|in:paypal,stripe,mollie,paystack,paysafecard,2checkout,cashu,razorpay,pagseguro',
			);

			// Make Validation
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				
				// Error
				return redirect('account/ads/upgrade/'.$ad->ad_id)->withErrors($validator);

			}else{

				// Get method
				$method = $request->get('method');

				// Check payment method
				switch ($method) {
					case 'paypal':
						return redirect('account/ads/'.$ad_id.'/checkout/paypal');
						break;
					case 'stripe':
						return redirect('account/ads/'.$ad_id.'/checkout/stripe');
						break;
					case '2checkout':
						return redirect('account/ads/'.$ad_id.'/checkout/2checkout');
						break;
					case 'mollie':
						return redirect('account/ads/'.$ad_id.'/checkout/mollie');
						break;
					case 'paystack':
						return redirect('account/ads/'.$ad_id.'/checkout/paystack');
						break;
					case 'paysafecard':
						return redirect('account/ads/'.$ad_id.'/checkout/paysafecard');
						break;
					case 'cashu':
						return redirect('account/ads/'.$ad_id.'/checkout/cashu');
						break;
					case 'razorpay':
						return redirect('account/ads/'.$ad_id.'/checkout/razorpay');
						break;
					case 'pagseguro':
						return redirect('account/ads/'.$ad_id.'/checkout/pagseguro');
						break;
					
					default:
						return redirect('account/ads/'.$ad_id.'/checkout/paypal');
						break;
				}

			}

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

	/**
	 * Success PayPal Payment
	 */
	public function paymentSuccess(Request $request, $ad_id)
	{
		// Get user id 
		$user_id = Auth::id();

		// Check if ad exists
		$ad = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {

			// Progress Payment
			try {
		
				$id               = $request->get('paymentId');
				$token            = $request->get('token');
				$payer_id         = $request->get('PayerID');
				
				$payment          = PayPal::getById($id, $this->_apiContext);
				
				$paymentExecution = PayPal::PaymentExecution();

				$paymentExecution->setPayerId($payer_id);
				$executePayment = $payment->execute($paymentExecution, $this->_apiContext);

				// Get Membership settings_membership
				$settings_membership = Helper::settings_membership();
				
				// Get Default Payment Currency
				$currency            = $settings_membership->currency;

				// Get Session Pack
				$pack = Session::get('pack');

				// Get Pack Info
				switch ($pack) {
					case '1':
						$price = $settings_membership->ad_1_month_price;
						$ends_at = Carbon::now()->addMonth();
						break;

					case '3':
						$price = $settings_membership->ad_3_months_price;
						$ends_at = Carbon::now()->addMonths(3);
						break;

					case '6':
						$price = $settings_membership->ad_6_months_price;
						$ends_at = Carbon::now()->addMonths(6);
						break;

					case '12':
						$price = $settings_membership->ad_12_months_price;
						$ends_at = Carbon::now()->addMonths(12);
						break;

					case '24':
						$price = $settings_membership->ad_24_months_price;
						$ends_at = Carbon::now()->addMonths(24);
						break;

					case '36':
						$price = $settings_membership->ad_36_months_price;
						$ends_at = Carbon::now()->addMonths(36);
						break;
					
					default:
						$price = $settings_membership->ad_1_months_price;
						$ends_at = Carbon::now()->addMonths(12);
						break;
				}

		    	// Payment Success, Create new ad payment
		    	$setPayment = DB::table('ads_payments')->insertGetId([
					'user_id'        => Auth::id(),
					'ad_id'          => $ad_id,
					'pack'           => $pack,
					'brand'          => 'paypal',
					'transaction_id' => $id,
					'card_number'    => NULL,
					'exp_year'       => NULL,
					'exp_month'      => NULL,
					'cvv'            => NULL,
					'card_last_four' => NULL,
					'amount'         => $price,
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
					'method'         => 'paypal',		
					'type'           => 'ad',		
					'transaction_id' => $id,		
					'user_id'        => Auth::id()
				]));

				// Add Payment Notification to databse
				DB::table('notifications_payments')->insert([
					'user_id'          => Auth::id(),
					'payment_id'       => $setPayment,
					'transaction_id'   => $id,
					'payment_method'   => 'paypal',
					'payment_type'     => 'ad',
					'payment_amount'   => $price,
					'payment_currency' => $currency,
					'created_at'       => Carbon::now(),
					'updated_at'       => Carbon::now(),
				]);

			    // Thank the user for the purchase
				return redirect('/')->with('success', __('return/success.lang_payment_success'));
				
			} catch (\Exception $e) {
				// Error
				return redirect('/account/ads/upgrade/'.$ad_id)->with('error', 'Oops! '.$e->getMessage());
			}

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
		
	}

	/**
	 * Failed Payment
	 */
	public function paymentFailed()
	{
		// Payment Failed
		return redirect('/')->with('error', __('return/error.lang_payment_failed'));
	}

	/**
	 * Archive Ad
	 */
	public function archive(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check if ad exists
		$ad = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {

			// Archive Ad
			Ad::where('ad_id', $ad_id)->update([
				'is_archived' => 1
			]);

			// success
			return redirect('/account/ads')->with('success', __('return/success.lang_ad_archived'));

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

	/**
	 * Ad Stats
	 */
	public function stats(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();

		// check ad
		$ad = Ad::where('ad_id', $ad_id)->where('status', 1)->where('user_id', $user_id)->first();

		if ($ad) {

			// Get stats
			$stats     = Stats::where('ad_id', $ad_id)->get();
			
			// Get Ad Visits
			$visits    = Charts::database($stats, 'line', 'highcharts')
							->title(Lang::get('ads/stats.lang_ad_visits'))
							->elementLabel(Lang::get('ads/stats.lang_total_visits'))
							->responsive(false)
							->dimensions(0,500)
							->lastByDay(7, true);
			
			// Get Ad Countries
			$countries = Charts::database($stats, 'geo', 'google')
							->title(Lang::get('ads/stats.lang_countries_map'))
							->elementLabel("Visits")
							->responsive(false)
							->dimensions(0,500)
							->colors(['#C5CAE9', '#283593'])
							->groupBy('country');
			
			// Get Ad Browsers
			$browsers  = Charts::database($stats, 'pie', 'highcharts')
							->title(Lang::get('ads/stats.lang_top_browsers'))
							->responsive(false)
							->dimensions(0,300)
							->groupBy('browserName');
			
			
			// Get Ad Platforms
			$platforms = Charts::database($stats, 'pie', 'highcharts')
							->title(Lang::get('ads/stats.lang_top_platforms'))
							->responsive(false)
							->dimensions(0,300)
							->groupBy('platformName');


			// Other Stats
			$other_stats = Stats::where('ad_id', $ad_id)->orderBy('id', 'desc')->paginate(30);


			// Data to show
			$data = array(
				'visits'      => $visits, 
				'countries'   => $countries, 
				'browsers'    => $browsers, 
				'platforms'   => $platforms, 
				'stats'       => $stats, 
				'other_stats' => $other_stats, 
			);

			// Get Tilte && Description
			$title      = Helper::settings_general()->title;
			$long_desc  = Helper::settings_seo()->description;
			$keywords   = Helper::settings_seo()->keywords;

			// Manage SEO
			SEO::setTitle(__('title.lang_statistics').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			return view($this->theme.'.account.stats')->with($data);

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

	/**
	 * Move Ad to Trash
	 */
	public function delete(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check Ad
		$ad = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('status', 1)->where('is_trashed', 0)->first();

		if ($ad) {
			
			// Move ad to trash
			Ad::where('ad_id', $ad_id)->update([
				'is_trashed'       => 1, 
				'trashed_by_admin' => 0, 
				'deleted_at'       => Carbon::now()
			]);

			// Success
			return redirect('/account/ads')->with('success', __('return/success.lang_ad_moved_to_trash'));

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

	/**
	 * Get Trashed ads
	 */
	public function trash()
	{
		// Get user id
		$user_id = Auth::id();

		// Get ads
		$ads = Ad::where('user_id', $user_id)->where('is_trashed', 1)->where('trashed_by_admin', 0)->paginate(30);

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_trashed_ads').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.ads.trash')->with('ads', $ads);
	}

	/**
	 * Restore Ad
	 */
	public function restore(Request $request, $ad_id)
	{
		// Get user_id
		$user_id = Auth::id();

		// Check ad
		$ad = Ad::where('user_id', $user_id)->where('ad_id', $ad_id)->where('status', 1)->where('is_trashed', 1)->where('trashed_by_admin', 0)->first();

		if ($ad) {
			
			// Restore Ad
			Ad::where('ad_id', $ad_id)->update([
				'is_trashed' => 0,
				'deleted_at' => null,
			]);

			// success
			return redirect('/account/ads')->with('success', __('return/success.lang_ad_restored'));

		}else{
			// Not found
			return redirect('/account/ads/trash')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

	/**
	 * Delete Ad Permanently
	 */
	public function remove(Request $request, $ad_id)
	{
		// Get user_id
		$user_id = Auth::id();

		// Check ad
		$ad = Ad::where('user_id', $user_id)->where('ad_id', $ad_id)->first();

		if ($ad) {
			
			// Delete Payments
			DB::table('ads_payments')->where('ad_id', $ad_id)->where('user_id', $user_id)->delete();

			// Delete Comments
			DB::table('comments')->where('ad_id', $ad_id)->delete();

			// delete likes
			DB::table('favorites')->where('ad_id', $ad_id)->delete();

			// Delete Notifications
			DB::table('notifications_ads')->where('ad_id', $ad_id)->delete();
			DB::table('notifications_ads_accepted')->where('ad_id', $ad_id)->delete();
			DB::table('notifications_comments')->where('ad_id', $ad_id)->delete();
			DB::table('notifications_likes')->where('ad_id', $ad_id)->delete();
			DB::table('notifications_reports')->where('ad_id', $ad_id)->delete();

			// delete offers
			DB::table('offers')->where('ad_id', $ad_id)->delete();

			// Delete Views
			DB::table('stats')->where('ad_id', $ad_id)->delete();

			// Delete Mails
			DB::table('users_mailbox')->where('ad_id', $ad_id)->delete();

			// Delete Ad Folder
			$ad_path = public_path().'/uploads/images/'.$ad_id.'/';
			Uploader::recursiveRemoveDirectory($ad_path);

			// Delete Ad
			Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->delete();

			// success
			return redirect('/account/ads')->with('success', __('return/success.lang_ad_deleted_permanently'));

		}else{
			// Not found
			return redirect('/account/ads/trash')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

}