<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Config;
use Helper;
use Carbon\Carbon;

/**
* MembershipController
*/
class MembershipController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Memebrship Settings
	 */
	public function membership()
	{

		// Get Settings
		$settings = DB::table('settings_payments')->where('id', 1)->first();
		$settings_membership = DB::table('settings_membership')->where('id', 1)->first();

		// Send data
		$data = array(
			'settings'            => $settings, 
			'settings_membership' => $settings_membership, 
		);

		return view('dashboard.settings.membership')->with($data);
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array(
			'is_paypal'        => 'required|boolean',
			'is_stripe'        => 'required|boolean',
			'is_2checkout'     => 'required|boolean',
			'is_mollie'        => 'required|boolean',
			'is_paystack'      => 'required|boolean',
			'is_paysafecard'   => 'required|boolean',
			'is_barion'        => 'required|boolean',
			'is_razorpay'      => 'required|boolean',
			'is_cashu'         => 'required|boolean',
			'is_paytm'         => 'required|boolean',
			'is_interkassa'    => 'required|boolean',
			'free_ads_per_day' => 'required|numeric',
			'pro_ads_per_day'  => 'required|numeric',
			'free_ad_images'   => 'required|numeric',
			'pro_ad_images'    => 'required|numeric',
			'free_ad_life'     => 'required|numeric',
			'pro_ad_life'      => 'required|numeric',
		);

		// Make validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			// error
			return redirect('dashboard/settings/membership')->withErrors($validator);
		}else{

			// Get inputs
			$is_paypal        = $request->get('is_paypal');
			$is_stripe        = $request->get('is_stripe');
			$is_2checkout     = $request->get('is_2checkout');
			$is_mollie        = $request->get('is_mollie');
			$is_paystack      = $request->get('is_paystack');
			$is_paysafecard   = $request->get('is_paysafecard');
			$is_barion        = $request->get('is_barion');
			$is_razorpay      = $request->get('is_razorpay');
			$is_cashu         = $request->get('is_cashu');
			$is_paytm         = $request->get('is_paytm');
			$is_interkassa    = $request->get('is_interkassa');
			$is_pagseguro     = $request->get('is_pagseguro');
			$free_ads_per_day = $request->get('free_ads_per_day');
			$pro_ads_per_day  = $request->get('pro_ads_per_day');
			$free_ad_images   = $request->get('free_ad_images');
			$pro_ad_images    = $request->get('pro_ad_images');
			$free_ad_life     = $request->get('free_ad_life');
			$pro_ad_life      = $request->get('pro_ad_life');

			// Update Settings
			DB::table('settings_payments')->where('id', 1)->update([
				'is_paypal'      => $is_paypal,
				'is_2checkout'   => $is_2checkout,
				'is_stripe'      => $is_stripe,
				'is_paystack'    => $is_paystack,
				'is_mollie'      => $is_mollie,
				'is_paysafecard' => $is_paysafecard,
				'is_barion'      => $is_barion,
				'is_razorpay'    => $is_razorpay,
				'is_cashu'       => $is_cashu,
				'is_pagseguro'   => $is_pagseguro,
				'is_paytm'       => $is_paytm,
				'is_interkassa'  => $is_interkassa,
			]);

			// Update Settings
			DB::table('settings_membership')->where('id', 1)->update([
				'free_ads_per_day' => $free_ads_per_day,
				'pro_ads_per_day'  => $pro_ads_per_day,
				'free_ad_images'   => $free_ad_images,
				'pro_ad_images'    => $pro_ad_images,
				'free_ad_life'     => $free_ad_life,
				'pro_ad_life'      => $pro_ad_life,
			]);

			// Success
			return redirect('dashboard/settings/membership')->with('success', 'Congratulations! Settings has been successfully updated.');

		}
	}

}