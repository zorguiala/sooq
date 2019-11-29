<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Helper;
use Config;

class CashUController extends Controller
{
    function __construct()
	{
		$this->middleware('admin');
	}

	/**
	* Get CashU payment gateway settings
	*/
	public function get()
	{
		// Set supported currencies by cashu
		$currencies = array('USD','AED','BHD','DZD','EGP','EUR','JOD','KWD','LBP','MAD','OMR','QAR','SAR ','TRY');

		return view('dashboard.settings.payments.cashu', compact('currencies'));
	}

	/**
	* Save CashU settings
	*/
	public function post(Request $request)
	{
		// Make Rules
		$rules = array(
			'currency'       => 'required|max:3|in:EUR,USD,AED,BHD,DZD,EGP,JOD,KWD,LBP,MAD,OMR,QAR,SAR,TRY', 
			'account_price'  => 'required',
			'ad_price'       => 'required',
			'encryption_key' => 'required',
			'merchant_id'    => 'required|numeric',
			'service_name'   => 'required',
			'session_id'     => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/cashu')->withErrors($validator);

		}else{

			// Get Inputs
			$currency       = $request->get('currency');
			$account_price  = $request->get('account_price');
			$ad_price       = $request->get('ad_price');
			$encryption_key = $request->get('encryption_key');
			$merchant_id    = $request->get('merchant_id');
			$service_name   = $request->get('service_name');
			$session_id     = $request->get('session_id');

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update CashU Settings
				Config::write('cashu', [
					'currency'        => $currency,
					'_encryption_key' => $encryption_key,
					'_merchant_id'    => $merchant_id,
					'service_name'    => $service_name,
					'_session_id'     => $session_id,
					'account_price'   => Helper::isCurrency($account_price),
					'ad_price'        => Helper::isCurrency($ad_price),
				]);

				// Success
				return redirect('dashboard/settings/payments/cashu')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/cashu')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}
	}
}
