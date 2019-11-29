<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Helper;
use Config;

/**
* PayStackController
*/
class PayStackController extends Controller
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
		return view('dashboard.settings.payments.paystack');
	}

	/**
	 * Update settings
	 */
	public function post(Request $request)
	{
		
		// Make Rules
		$rules = array(
			'currency'      => 'required|max:3|in:NGN', 
			'account_price' => 'required',
			'ad_price'      => 'required',
			'publicKey'     => 'required',
			'secretKey'     => 'required',
			'merchantEmail' => 'required|email',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/paystack')->withErrors($validator);

		}else{

			// Get Inputs
			$currency      = $request->get('currency');
			$account_price = $request->get('account_price');
			$ad_price      = $request->get('ad_price');
			$publicKey     = $request->get('publicKey');
			$secretKey     = $request->get('secretKey');
			$merchantEmail = $request->get('merchantEmail');

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update PayStack Settings
				Config::write('paystack', [
					'currency'      => $currency,
					'publicKey'     => $publicKey,
					'secretKey'     => $secretKey,
					'merchantEmail' => $merchantEmail,
					'account_price' => Helper::isCurrency($account_price),
					'ad_price'      => Helper::isCurrency($ad_price),
				]);

				// Success
				return redirect('dashboard/settings/payments/paystack')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/paystack')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}

	}

}