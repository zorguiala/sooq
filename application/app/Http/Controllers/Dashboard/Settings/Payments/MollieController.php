<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Helper;
use Config;
use Protocol;

/**
* MollieController
*/
class MollieController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit Mollie settings
	 */
	public function get()
	{
		return view('dashboard.settings.payments.mollie');
	}

	/**
	 * Update settings
	 */
	public function post(Request $request)
	{
		
		// Make Rules
		$rules = array(
			'currency'         => 'required|max:3|in:EUR', 
			'account_price'    => 'required',
			'ad_price'         => 'required',
			'mollie_api_key'   => 'required',
			'mollie_client_id' => 'required',
			'mollie_secret'    => 'required',
			'mollie_redirect'  => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/mollie')->withErrors($validator);

		}else{

			// Get Inputs
			$currency         = $request->get('currency');
			$account_price    = $request->get('account_price');
			$ad_price         = $request->get('ad_price');
			$mollie_api_key   = $request->get('mollie_api_key');
			$mollie_client_id = $request->get('mollie_client_id');
			$mollie_secret    = $request->get('mollie_secret');
			$mollie_redirect  = $request->get('mollie_redirect');

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update Mollie Settings
				Config::write('services', [
					'mollie.currency'      => $currency,
					'mollie.client_id'     => $mollie_client_id,
					'mollie.client_secret' => $mollie_secret,
					'mollie.account_price' => Helper::isCurrency($account_price),
					'mollie.ad_price'      => Helper::isCurrency($ad_price),
					'mollie.redirect'      => Protocol::home().'/checkout/mollie/callback',
				]);

				// Update Mollie API
				Config::write('mollie', [
					'keys.live'      => $mollie_api_key,
				]);

				// Success
				return redirect('dashboard/settings/payments/mollie')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/mollie')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}

	}

}