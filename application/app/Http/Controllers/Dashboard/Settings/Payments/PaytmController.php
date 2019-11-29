<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Config;
use Helper;

class PaytmController extends Controller
{
    function __construct()
	{
		$this->middleware('admin');
	}

	/**
	* Get Paytm Gateway Settings
	*/
	public function get()
	{
		return view('dashboard.settings.payments.paytm');
	}

	/**
	* Update Paytm Settings
	*/
	public function post(Request $request)
	{
		// Make Rules
		$rules = array(
			'env'              => 'required|in:local,production', 
			'merchant_id'      => 'required',
			'merchant_key'     => 'required',
			'merchant_website' => 'required',
			'channel'          => 'required',
			'industry_type'    => 'required',
			'account_price'    => 'required',
			'ad_price'         => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/paytm')->withErrors($validator);

		}else{

			// Get Inputs
			$env              = $request->get('env');
			$account_price    = $request->get('account_price');
			$ad_price         = $request->get('ad_price');
			$merchant_id      = $request->get('merchant_id');
			$merchant_key     = $request->get('merchant_key');
			$merchant_website = $request->get('merchant_website');
			$channel          = $request->get('channel');
			$industry_type    = $request->get('industry_type');

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update CashU Settings
				Config::write('services', [
					'paytm-wallet.env'              => $env,
					'paytm-wallet.account_price'    => Helper::isCurrency($account_price),
					'paytm-wallet.ad_price'         => Helper::isCurrency($ad_price),
					'paytm-wallet.merchant_id'      => $merchant_id,
					'paytm-wallet.merchant_key'     => $merchant_key,
					'paytm-wallet.merchant_website' => $merchant_website,
					'paytm-wallet.channel'          => $channel,
					'paytm-wallet.industry_type'    => $industry_type,
				]);

				// Success
				return redirect('dashboard/settings/payments/paytm')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/paytm')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}
	}
}
