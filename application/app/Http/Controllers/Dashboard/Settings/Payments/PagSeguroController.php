<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Config;
use Helper;

class PagSeguroController extends Controller
{
    function __construct()
	{
		$this->middleware('admin');
	}

	/**
	* Get PagSeguro Gateway Settings
	*/
	public function get()
	{
		return view('dashboard.settings.payments.pagseguro');
	}

	/**
	* Update PagSeguro Settings
	*/
	public function post(Request $request)
	{
		// Make Rules
		$rules = array(
			'currency'        => 'required|max:3|in:BRL', 
			'account_price'   => 'required',
			'ad_price'        => 'required',
			'email'           => 'required|email',
			'token'           => 'required',
			'notificationURL' => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/pagseguro')->withErrors($validator);

		}else{

			// Get Inputs
			$currency        = $request->get('currency');
			$account_price   = $request->get('account_price');
			$ad_price        = $request->get('ad_price');
			$email           = $request->get('email');
			$token           = $request->get('token');
			$notificationURL = $request->get('notificationURL');
			$sandbox         = $request->get('sandbox');
			
			if ($sandbox) {
				$sandbox = true;
			}else{
				$sandbox = false;
			}

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update CashU Settings
				Config::write('pagseguro', [
					'sandbox'         => $sandbox,
					'email'           => $email,
					'token'           => $token,
					'notificationURL' => $notificationURL,
					'ad_price'        => Helper::isCurrency($ad_price),
					'account_price'   => Helper::isCurrency($account_price),
				]);

				// Success
				return redirect('dashboard/settings/payments/pagseguro')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/pagseguro')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}
	}
}
