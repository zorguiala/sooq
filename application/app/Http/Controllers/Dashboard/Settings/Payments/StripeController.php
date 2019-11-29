<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Helper;
use Config;
use Currencies;

/**
* StripeController
*/
class StripeController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit PayPal settings
	 */
	public function get()
	{
		return view('dashboard.settings.payments.stripe');
	}

	/**
	 * Update settings
	 */
	public function post(Request $request)
	{
		
		// Make Rules
		$rules = array(
			'currency'      => 'required|max:3', 
			'account_price' => 'required',
			'ad_price'      => 'required',
			'secret'        => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/stripe')->withErrors($validator);

		}else{

			// Get Inputs
			$currency      = $request->get('currency');
			$account_price = $request->get('account_price');
			$ad_price      = $request->get('ad_price');
			$secret        = $request->get('secret');
			
			// Check if currency exists
			$currencies    = Currencies::TwoCheckout();

			if (!array_key_exists($currency, $currencies)) {
			    
				// Currency not supported
				return redirect('dashboard/settings/payments/stripe')->with('error', 'Oops! Currency not supported.');

			}

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update PayPal Settings
				Config::write('services', [
					'stripe.currency'      => $currency,
					'stripe.secret'        => $secret,
					'stripe.account_price' => Helper::isCurrency($account_price),
					'stripe.ad_price'      => Helper::isCurrency($ad_price),
				]);

				// Success
				return redirect('dashboard/settings/payments/stripe')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/stripe')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}

	}

}