<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Mollie;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAccountPayment;
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
	public function get()
	{
		// Check if gateway is enabled
		if (!Helper::settings_payments()->is_mollie) {
			
			// Not enabled
			return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

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

		return view($this->theme.'.checkout.mollie');
	}

	/**
	 * Checkout
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
			if ($days < 10) {
				// Error
				return redirect('checkout/mollie')->with('error', 'Oops! Days must be greater than 10 days');
			}
			
			// Set Total price
			$total_price = $days * config('services.mollie.account_price');

			// Set Currency
			$currency = config('services.mollie.currency');

			try {
				
				$payment = Mollie::api()->payments()->create([
				    "amount"      => $total_price,
				    "description" => "Upgrade Your Account!",
				    "redirectUrl" => Protocol::home()."/checkout/mollie/callback",
				]);

				// Put days in session
				Session::put('mollie_payment_id', $payment->id);
				Session::put('account_upgrade_days', $days);

				// Redirect to payment page
				return redirect($payment->links->paymentUrl);

			} catch (\Exception $e) {
				
				// Error
				return redirect('checkout/mollie')->with('error', 'Oops! '.$e->getMessage());

			}
			

		}else{

			// Error
			return redirect('checkout/mollie')->withErrors($validator);

		}
		
	}

	public function callback()
	{
		// Get Payment ID
		$payment_id = Session::get('mollie_payment_id');
		
		$payment    = Mollie::api()->payments()->get($payment_id);

		if ($payment->isPaid()){

			// Get Default Payment Currency
			$currency         = config('services.mollie.currency');
			
			// Get days
			$days             = Session::get('account_upgrade_days');
			
			// Get Total Price
			$total_price      = $days * config('services.mollie.account_price');
			
			// Set Expire date
			$ends_at          = Carbon::now()->addDays($days);

	    	// Payment Success, Create new Subscription
			$subscription                 = new Subscription;
			$subscription->user_id        = Auth::id();
			$subscription->days           = $days;
			$subscription->brand          = 'mollie';
			$subscription->transaction_id = $payment_id;
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
				'method'         => 'mollie',		
				'type'           => 'account',		
				'transaction_id' => $payment_id,		
				'user_id'        => Auth::id()
			]));

			// Add Payment Notification to databse
			DB::table('notifications_payments')->insert([
				'user_id'          => Auth::id(),
				'payment_id'       => $subscription->id,
				'transaction_id'   => $payment_id,
				'payment_method'   => 'mollie',
				'payment_type'     => 'account',
				'payment_amount'   => $total_price,
				'payment_currency' => $currency,
				'created_at'       => Carbon::now(),
				'updated_at'       => Carbon::now(),
			]);

			// Delete Session values
			Session::forget('mollie_payment_id');
			Session::forget('account_upgrade_days');

			// Thank the user for the upgrade
			return redirect('/checkout/mollie')->with('success', __('return/success.lang_payment_success'));

		}else{

			// Payment Failed
			return redirect('checkout/mollie')->with('error', __('return/error.lang_payment_failed'));

		}

	}

}