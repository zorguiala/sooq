<?php

namespace App\Http\Controllers\Ads\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use PayPal;
use Protocol;
use Redirect;
use App\User;
use Session;
use App\Models\Ad;
use App\Notifications\Payments\Admin\NewAdPayment;
use DB;
use Helper;
use SEOMeta;
use SEO;
use Theme;

/**
 * PayPalController
 */

class PayPalController extends Controller
{
    public $theme = '';

	private $_apiContext;

    public function __construct()
    {
		$this->middleware('auth');
        $this->theme = Theme::get();
        
        $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));
		
		$this->_apiContext->setConfig(array(
			'mode'                   => 'live',
			'service.EndPoint'       => 'https://api.paypal.com',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled'         => true,
			'log.FileName'           => storage_path('logs/paypal.log'),
			'log.LogLevel'           => 'FINE'
		));

    }

	/**
	 * Pay with paypal
	 */
	public function get(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();
		
		// Check if ad exists
		$ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {

			// Check if gateway is enabled
			if (!Helper::settings_payments()->is_paypal) {
				
				// Not enabled
				return redirect('account/ads/upgrade/'.$ad_id)->with('error', __('update.lang_gateway_not_enabled'));

			}

			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle(__('update.lang_paypal_checkout').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			return view($this->theme.'.account.ads.checkout.paypal', compact('ad'));

		}else{
			// Not found
			return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

	public function post(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();
		
		// Check if ad exists
		$ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {

			// Make validation
			$validator = Validator::make($request->all(), [
				'days' => 'required|numeric'
			]);

			if ($validator->fails()) {
				
				// Error
				return redirect('account/ads/'.$ad_id.'/checkout/paypal')->withErrors($validator);

			}

			// Get Days
			$days = $request->get('days');

			// Days must be between 7 days
			if ($days < 7) {
				// Error
				return redirect('account/ads/'.$ad_id.'/checkout/paypal')->with('error', 'Oops! Days must be greater than week');
			}

			// Set total price
			$total_price  = $days * config('services.paypal.ad_price');

			// Set Payment Method
			$payer        = PayPal::Payer();
			$payer->setPaymentMethod('paypal');
		
			$amount       = PayPal::Amount();
			$amount->setCurrency(config('services.paypal.currency'));
			$amount->setTotal($total_price);
			
			$transaction  = PayPal::Transaction();
			$transaction->setAmount($amount);
			$transaction->setDescription('Upgrade your ad for '.$days.' days');
			
			$redirectUrls = PayPal:: RedirectUrls();
			$redirectUrls->setReturnUrl(action('Ads\Payments\PayPalController@success', ['ad_id' => $ad_id]));
			$redirectUrls->setCancelUrl(action('Ads\Payments\PayPalController@failed', ['ad_id' => $ad_id]));
			
			$payment      = PayPal::Payment();
			$payment->setIntent('sale');
			$payment->setPayer($payer);
			$payment->setRedirectUrls($redirectUrls);
			$payment->setTransactions(array($transaction));
			$payment->setExperienceProfileId($this->createWebProfile());
			
			$response     = $payment->create($this->_apiContext);
			$redirectUrl  = $response->links[1]->href;

			// Put days in session
			Session::put('ad_upgrade_days', $days);
			
			return Redirect::to( $redirectUrl );

		}else{
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
        }
	}

	public function success(Request $request, $ad_id)
	{
		// Get user id
		$user_id = Auth::id();
		
		// Check if ad exists
		$ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

		if ($ad) {

			try {
				
				$id               = $request->get('paymentId');
				$token            = $request->get('token');
				$payer_id         = $request->get('PayerID');
				
				$payment          = PayPal::getById($id, $this->_apiContext);
				
				$paymentExecution = PayPal::PaymentExecution();
				
				$paymentExecution->setPayerId($payer_id);
				$executePayment   = $payment->execute($paymentExecution, $this->_apiContext);
				
				// Get Default Payment Currency
				$currency         = config('services.paypal.currency');
				
				// Get days
				$days             = Session::get('ad_upgrade_days');
				
				// Get Total Price
				$total_price      = $days * config('services.paypal.ad_price');
				
				// Set Expire date
				$ends_at          = Carbon::now()->addDays($days);

		    	// Payment Success, Create new ad payment
		    	$setPayment = DB::table('ads_payments')->insertGetId([
					'user_id'        => Auth::id(),
					'ad_id'          => $ad_id,
					'days'           => $days,
					'brand'          => 'paypal',
					'transaction_id' => $id,
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
					'payment_amount'   => $total_price,
					'payment_currency' => $currency,
					'created_at'       => Carbon::now(),
					'updated_at'       => Carbon::now(),
				]);

				// Delete Session values
                Session::forget('ad_upgrade_days');

			    // Thank the user for the upgrade
				return redirect('account/ads/'.$ad_id.'/checkout/paypal')->with('success', __('return/success.lang_payment_success'));
				
			} catch (\Exception $e) {
				// Error
				return redirect('account/ads/'.$ad_id.'/checkout/paypal')->with('error', 'Oops! '.$e->getMessage());
			}

		}else{
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
        }
	}

	public function failed()
	{
		// Delete Session values
        Session::forget('ad_upgrade_days');
        
	    // Payment Failed
		return redirect('/account/ads')->with('error', __('return/error.lang_payment_failed'));
	}

	public function createWebProfile(){

		$flowConfig            = PayPal::FlowConfig();
		$presentation          = PayPal::Presentation();
		$inputFields           = PayPal::InputFields();
		$webProfile            = PayPal::WebProfile();
		$flowConfig->setLandingPageType("Billing"); //Set the page type
		
		$presentation->setLogoImage(Protocol::home().'/application/public/uploads/settings/logo/logo.png')->setBrandName(config('app.name'));
		
		$inputFields->setAllowNote(true)->setNoShipping(1)->setAddressOverride(0);
		
		$webProfile->setName(config('app.name') . uniqid())
		->setFlowConfig($flowConfig)
		// Parameters for style and presentation.
		->setPresentation($presentation)
		// Parameters for input field customization.
		->setInputFields($inputFields);
		
		$createProfileResponse = $webProfile->create($this->_apiContext);
		
		return $createProfileResponse->getId();
	}

}