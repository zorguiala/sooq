<?php

namespace App\Http\Controllers\Ads\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use Protocol;
use Theme;
use Auth;
use Helper;
use SEO;
use SEOMeta;
use Validator;
use CashU;

class CashUController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	* Pay using cashu
	*/
	public function get(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();
		
		// Check if ad exists
		$ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {

			// Check if gateway is enabled
			if (!Helper::settings_payments()->is_cashu) {
				
				// Not enabled
				return redirect('account/ads/upgrade/'.$ad_id)->with('error', __('update.lang_gateway_not_enabled'));

			}

			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle('Pay using CashU | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			return view($this->theme.'.account.ads.checkout.cashu', compact('ad'));

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

	/**
	* Handle payment
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

				// Get upgrade days
		    	$days = $request->get('days');

				// Days must be between 10 and 5000 days
				if ($days < 7) {
					// Error
					return redirect('account/ads/'.$ad_id.'/checkout/cashu')->with('error', 'Oops! Days must be greater than week');
				}

				// Set Total price
				$total_price = $days * config('cashu.ad_price');

		    	// Handle new payment
		    	$data = array(
					'amount'       => $total_price, 
					'currency'     => config('cashu.currency'),
					'display_text' => 'Payment using cashU',
					'lang'         => config('cashu.lang'),
					'item1'        => 'Upgrade Your Ad Now',
					'item2'        => '',
					'item3'        => '',
					'item4'        => '',
					'item5'        => '',
					'service_name' => config('cashu.service_name'),
		    	);

		    	// start the payment
				return CashU::Go($data);

			}else{

				// Error
				return redirect('account/ads/'.$ad_id.'/checkout/cashu')->withErrors($validator);

			}

		}else{

			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));

		}
    }

    /**
	* Get Payment response
    */
    public function callback(Request $request)
    {
    	// check if payment success
    	if ($request->get('session_id') == config('cashu._session_id')) {

			// Get Payment Currency
			$currency    = $request->get('currency');
			
			// Get days
			$total_price = $request->get('amount');
			
			// Get Total Price
			$days        = $total_price / config('cashu.account_price');
			
			// Set Expire date
			$ends_at     = Carbon::now()->addDays($days);

	    	// Payment Success, Create new Subscription
			$subscription                 = new Subscription;
			$subscription->user_id        = Auth::id();
			$subscription->days           = $days;
			$subscription->brand          = 'cashu';
			$subscription->transaction_id = $request->get('token');
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
				'method'         => 'cashu',		
				'type'           => 'account',		
				'transaction_id' => $request->get('token'),		
				'user_id'        => Auth::id()
			]));

			// Add Payment Notification to databse
			DB::table('notifications_payments')->insert([
				'user_id'          => Auth::id(),
				'payment_id'       => $subscription->id,
				'transaction_id'   => $request->get('token'),
				'payment_method'   => 'cashu',
				'payment_type'     => 'account',
				'payment_amount'   => $total_price,
				'payment_currency' => $currency,
				'created_at'       => Carbon::now(),
				'updated_at'       => Carbon::now(),
			]);

			// Thank the user for the upgrade
			return redirect('/checkout/cashu')->with('success', __('return/success.lang_payment_success'));

		}else{

    		// Payment Failed
    		return redirect('/checkout/cashu')->with('error', __('return/error.lang_payment_failed'));

    	}
    }

    /**
	* Payment Failed
    */
    public function failed(Request $request)
    {
    	// Payment Failed
		return redirect('/checkout/cashu')->with('error', __('return/error.lang_payment_failed'));
    }
}
