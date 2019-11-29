<?php

namespace App\Http\Controllers\Payments;

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
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAccountPayment;
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

	private $_apiContext;
	
    public $theme = '';

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
	public function get()
	{
		// Check if gateway is enabled
		if (!Helper::settings_payments()->is_paypal) {
			
			// Not enabled
			return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

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

		return view($this->theme.'.checkout.paypal');
	}

	public function post(Request $request)
	{
		// Make validation
		$validator = Validator::make($request->all(), [
			'days' => 'required|numeric'
		]);

		if ($validator->fails()) {
			
			// Error
			return redirect('checkout/paypal')->withErrors($validator);

		}

		// Get Days
		$days = $request->get('days');

		// Days must be between 10 and 5000 days
		if ($days < 10) {
			// Error
			return redirect('checkout/paypal')->with('error', 'Oops! Days must be greater than 10 days');
		}

		// Set total price
		$total_price  = $days * config('services.paypal.account_price');

		// Set Payment Method
		$payer        = PayPal::Payer();
		$payer->setPaymentMethod('paypal');
	
		$amount       = PayPal::Amount();
		$amount->setCurrency(config('services.paypal.currency'));
		$amount->setTotal($total_price);
		
		$transaction  = PayPal::Transaction();
		$transaction->setAmount($amount);
		$transaction->setDescription('Upgrade your account for '.$days.' days');
		
		$redirectUrls = PayPal:: RedirectUrls();
		$redirectUrls->setReturnUrl(action('Payments\PayPalController@success'));
		$redirectUrls->setCancelUrl(action('Payments\PayPalController@failed'));
		
		$payment      = PayPal::Payment();
		$payment->setIntent('sale');
		$payment->setPayer($payer);
		$payment->setRedirectUrls($redirectUrls);
		$payment->setTransactions(array($transaction));
		$payment->setExperienceProfileId($this->createWebProfile());
		
		$response     = $payment->create($this->_apiContext);
		$redirectUrl  = $response->links[1]->href;

		// Put days in session
		Session::put('account_upgrade_days', $days);
		
		return Redirect::to( $redirectUrl );
	}

	public function success(Request $request)
	{
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
			$days             = Session::get('account_upgrade_days');
			
			// Get Total Price
			$total_price      = $days * config('services.paypal.account_price');
			
			// Set Expire date
			$ends_at          = Carbon::now()->addDays($days);

	    	// Payment Success, Create new Subscription
			$subscription                 = new Subscription;
			$subscription->user_id        = Auth::id();
			$subscription->days           = $days;
			$subscription->brand          = 'paypal';
			$subscription->transaction_id = $id;
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
				'method'         => 'paypal',		
				'type'           => 'account',		
				'transaction_id' => $id,		
				'user_id'        => Auth::id()
			]));

			// Add Payment Notification to databse
			DB::table('notifications_payments')->insert([
				'user_id'          => Auth::id(),
				'payment_id'       => $subscription->id,
				'transaction_id'   => $id,
				'payment_method'   => 'paypal',
				'payment_type'     => 'account',
				'payment_amount'   => $total_price,
				'payment_currency' => $currency,
				'created_at'       => Carbon::now(),
				'updated_at'       => Carbon::now(),
			]);

			// Delete Session values
			Session::forget('account_upgrade_days');

		    // Thank the user for the upgrade
			return redirect('/checkout/paypal')->with('success', __('return/success.lang_payment_success'));
			
		} catch (\Exception $e) {
			// Error
			return redirect('/checkout/paypal')->with('error', 'Oops! '.$e->getMessage());
		}
	}

	public function failed()
	{
		// Delete Session values
        Session::forget('account_upgrade_days');

	    // Payment Failed
		return redirect('checkout/paypal')->with('error', __('return/error.lang_payment_failed'));
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