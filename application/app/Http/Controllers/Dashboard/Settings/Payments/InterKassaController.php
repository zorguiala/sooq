<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Config;
use Helper;

class InterKassaController extends Controller
{
    function __construct()
	{
		$this->middleware('admin');
	}

	/**
	* Get InterKassa Gateway Settings
	*/
	public function get()
	{
		return view('dashboard.settings.payments.interkassa');
	}

	/**
	* Update InterKassa Settings
	*/
	public function post(Request $request)
	{
		// Make Rules
		$rules = array(
			'secret_key'    => 'required',
			'shop_id'       => 'required',
			'account_price' => 'required',
			'ad_price'      => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/interkassa')->withErrors($validator);

		}else{

			// Get Inputs
			$shop_id       = $request->get('shop_id');
			$secret_key    = $request->get('secret_key');
			$account_price = $request->get('account_price');
			$ad_price      = $request->get('ad_price');

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update CashU Settings
				Config::write('interkassa', [
					'shop_id'       => $shop_id,
					'account_price' => Helper::isCurrency($account_price),
					'ad_price'      => Helper::isCurrency($ad_price),
					'secret_key'    => $secret_key,
				]);

				// Success
				return redirect('dashboard/settings/payments/interkassa')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/interkassa')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}
	}
}
