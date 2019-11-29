<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Helper;
use Config;

/**
* PayPalController
*/
class PayPalController extends Controller
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
		return view('dashboard.settings.payments.paypal');
	}

	/**
	 * Update settings
	 */
	public function post(Request $request)
	{
		
		// Make Rules
		$rules = array(
			'currency'         => 'required|max:3|in:AUD,BRL,CAD,CZK,DKK,EUR,HKD,HUF,JPY,MYR,MXN,NOK,NZD,PHP,PLN,GBP,RUB,SGD,SEK,CHF,TWD,THB,USD', 
			'account_price'    => 'required',
			'ad_price'         => 'required',
			'paypal_client_id' => 'required',
			'paypal_secret'    => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/paypal')->withErrors($validator);

		}else{

			// Get Inputs
			$currency         = $request->get('currency');
			$account_price    = $request->get('account_price');
			$ad_price         = $request->get('ad_price');
			$paypal_client_id = $request->get('paypal_client_id');
			$paypal_secret    = $request->get('paypal_secret');

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update PayPal Settings
				Config::write('services', [
					'paypal.currency'      => $currency,
					'paypal.client_id'     => $paypal_client_id,
					'paypal.secret'        => $paypal_secret,
					'paypal.account_price' => Helper::isCurrency($account_price),
					'paypal.ad_price'      => Helper::isCurrency($ad_price),
				]);

				// Success
				return redirect('dashboard/settings/payments/paypal')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/paypal')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}

	}

}