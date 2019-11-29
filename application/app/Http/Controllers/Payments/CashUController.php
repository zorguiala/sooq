<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Payments\Admin\NewAccountPayment;
use App\Models\Subscription;
use App\User;
use Carbon\Carbon;
use CashU;
use Theme;
use Protocol;
use Helper;
use SEO;
use SEOMeta;
use Validator;
use Auth;
use DB;

class CashUController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
    * Pay using CashU
    */
    public function get()
	{
		// Check if gateway is enabled
		if (!Helper::settings_payments()->is_cashu) {
			
			// Not enabled
			return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

		}

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('update_three.lang_cashu_checkout').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.checkout.cashu');
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
				return redirect('checkout/cashu')->with('error', 'Oops! Days must be greater than 10 days');
			}

			// Set Total price
			$total_price = $days * config('cashu.account_price');

	    	// Handle new payment
	    	$data = array(
				'amount'       => $total_price, 
				'currency'     => config('cashu.currency'),
				'display_text' => 'Payment using cashU',
				'lang'         => config('cashu.lang'),
				'item1'        => 'Upgrade Your Account Now',
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
			return redirect('checkout/cashu')->withErrors($validator);

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
