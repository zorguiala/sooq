<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Config;
use Helper;

class BarionController extends Controller
{
    function __construct()
	{
		$this->middleware('admin');
	}

	/**
	* Get Barion Gateway Settings
	*/
	public function get()
	{
		return view('dashboard.settings.payments.barion');
	}

	/**
	* Update Barion Settings
	*/
	public function post(Request $request)
	{
		// Make Rules
		$rules = array(
			'currency'      => 'required|max:3|in:HUF', 
			'account_price' => 'required',
			'ad_price'      => 'required',
			'pos_key'       => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/barion')->withErrors($validator);

		}else{

			// Get Inputs
			$currency      = $request->get('currency');
			$account_price = $request->get('account_price');
			$ad_price      = $request->get('ad_price');
			$pos_key       = $request->get('pos_key');

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update CashU Settings
				Config::write('services', [
					'barion.currency'      => $currency,
					'barion.pos_key'       => $pos_key,
					'barion.account_price' => Helper::isCurrency($account_price),
					'barion.ad_price'      => Helper::isCurrency($ad_price),
				]);

				// Success
				return redirect('dashboard/settings/payments/barion')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/barion')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}
	}
}
