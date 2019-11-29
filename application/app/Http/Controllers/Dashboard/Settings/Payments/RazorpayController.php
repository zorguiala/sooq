<?php

namespace App\Http\Controllers\Dashboard\Settings\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Config;
use Helper;
use Image;
use Protocol;

class RazorpayController extends Controller
{
    function __construct()
	{
		$this->middleware('admin');
	}

	/**
	* Get RazorPay Settings
	*/
	public function get()
	{
		return view('dashboard.settings.payments.razorpay');
	}

	/**
	* Update RazorPay Settings
	*/
	public function post(Request $request)
	{
		// Make Rules
		$rules = array(
			'currency'      => 'required|max:3|in:INR', 
			'account_price' => 'required',
			'ad_price'      => 'required',
			'razor_key'     => 'required',
			'razor_secret'  => 'required',
			'logo'  		=> 'image|mimes:jpg,jpeg,png|max:3000',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('dashboard/settings/payments/razorpay')->withErrors($validator);

		}else{

			// Get Inputs
			$currency      = $request->get('currency');
			$account_price = $request->get('account_price');
			$ad_price      = $request->get('ad_price');
			$razor_key     = $request->get('razor_key');
			$razor_secret  = $request->get('razor_secret');
			$logo  		   = $request->file('logo');

			// Check price format
			if (Helper::isCurrency($ad_price) && Helper::isCurrency($account_price)) {
				
				// Update RazorPay Settings
				Config::write('razorpay', [
					'currency'      => $currency,
					'razor_key'     => $razor_key,
					'razor_secret'  => $razor_secret,
					'account_price' => Helper::isCurrency($account_price),
					'ad_price'      => Helper::isCurrency($ad_price),
				]);

				// Check if request has logo file
				if ($logo) {
					
					// Delete Old logo
					if (is_file(public_path().'/uploads/settings/logo/razorpay/logo.png')) {
						unlink(public_path().'/uploads/settings/logo/razorpay/logo.png');
					}

					// Upload new logo
					$logo_name   = 'logo.png';
					
					// Upload logo
					$upload_logo = Image::make($logo->getRealPath());

					// Resize logo
					$upload_logo->resize(100, 100);
					
					// Save logo
					$upload_logo->save(public_path().'/uploads/settings/logo/razorpay/'.$logo_name);

					// Get logo url
					$logo_url    = Protocol::home().'/application/public/uploads/settings/logo/razorpay/'.$logo_name;

					// Update logo url
					Config::write('razorpay', [
						'logo'   => $logo_url,
					]);

				}

				// Success
				return redirect('dashboard/settings/payments/razorpay')->with('success', 'Congratulations! Settings has been successfully updated.');

			}else{

				// Price format Invalid
				return redirect('dashboard/settings/payments/razorpay')->with('error', 'Oops! Price format is invalid. Please try again.');

			}

		}
	}
}
