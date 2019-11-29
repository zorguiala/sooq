<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Helper;
use Config;
use Currencies;

/**
* TwoCheckoutController
*/
class TwoCheckoutController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit 2checkout settings
	 */
	public function get()
	{
		return view('dashboard.settings.payments.2checkout');
	}

	/**
	 * Update settings
	 */
	public function post(Request $request)
	{
		
		// Make Rules
		$rules = array(
			'currency'                  => 'required|max:3', 
			'account_price'             => 'required',
			'ad_price'                  => 'required',
			'2checkout_seller_id'       => 'required',
			'2checkout_publishable_Key' => 'required',
			'2checkout_private_Key'     => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/paypal')->withErrors($validator);

		}else{

			// Get Inputs
			$currency          = $request->get('currency');
			$account_price     = $request->get('account_price');
			$ad_price          = $request->get('ad_price');
			$t_seller_id       = $request->get('2checkout_seller_id');
			$t_publishable_Key = $request->get('2checkout_publishable_Key');
			$t_private_Key     = $request->get('2checkout_private_Key');
			
			// Check if currency exists
			$currencies        = Currencies::TwoCheckout();

			if (!array_key_exists($currency, $currencies)) {
			    
				// Currency not supported
				return redirect('dashboard/settings/payments/2checkout')->with('error', 'Oops! Currency not supported.');

			}

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update PayPal Settings
				Config::write('services', [
					'2checkout.currency'        => $currency,
					'2checkout.seller_id'       => $t_seller_id,
					'2checkout.publishable_Key' => $t_publishable_Key,
					'2checkout.private_key'     => $t_private_Key,
					'2checkout.account_price'   => Helper::isCurrency($account_price),
					'2checkout.ad_price'        => Helper::isCurrency($ad_price),
				]);

				// Success
				return redirect('dashboard/settings/payments/2checkout')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/2checkout')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}

	}

}