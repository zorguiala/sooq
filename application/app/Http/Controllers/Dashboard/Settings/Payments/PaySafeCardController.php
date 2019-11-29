<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Helper;
use Config;

/**
* PaySafeCardController
*/
class PaySafeCardController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit PaySafeCard settings
	 */
	public function get()
	{
		return view('dashboard.settings.payments.paysafecard');
	}

	/**
	 * Update settings
	 */
	public function post(Request $request)
	{
		
		// Make Rules
		$rules = array(
			'currency'      => 'required|max:3|in:EUR,GBP,USD,SKK,NOK,RON,TRY', 
			'account_price' => 'required',
			'ad_price'      => 'required',
			'psc_key'       => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/paysafecard')->withErrors($validator);

		}else{

			// Get Inputs
			$currency      = $request->get('currency');
			$account_price = $request->get('account_price');
			$ad_price      = $request->get('ad_price');
			$psc_key       = $request->get('psc_key');

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update PayPal Settings
				Config::write('paysafecard', [
					'currency'      => $currency,
					'psc_key'       => $psc_key,
					'account_price' => Helper::isCurrency($account_price),
					'ad_price'      => Helper::isCurrency($ad_price),
				]);

				// Success
				return redirect('dashboard/settings/payments/paysafecard')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/paysafecard')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}

	}

}