<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Config;
use DB;

/**
* SecurityController
*/
class SecurityController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get security settings
	 */
	public function security()
	{
		$settings = DB::table('settings_security')->where('id', 1)->first();

		return view('dashboard.settings.security')->with('settings', $settings);
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array( 
			'recaptcha'             => 'required|boolean', 
			'captcha_sitekey'       => 'required_if:recaptcha,1', 
			'captcha_secretkey'     => 'required_if:recaptcha,1', 
			'max_attempts'          => 'required|numeric', 
			'unlock_time'           => 'required|numeric', 
			'auto_approve_ads'      => 'required|boolean', 
			'auto_approve_comments' => 'required|boolean', 
			'max_image_size'        => 'required|numeric', 
		);

		// Run rules
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			// Error
			return back()->withErrors($validator);
		}else{

			// Update Settings
			DB::table('settings_security')->where('id', 1)->update([
				'auto_approve_ads'      => $request->get('auto_approve_ads'),
				'auto_approve_comments' => $request->get('auto_approve_comments'),
				'blacklist_username'    => $request->get('blacklist_username'),
				'recaptcha'             => $request->get('recaptcha'),
				'max_attempts'          => $request->get('max_attempts'),
				'unlock_time'           => $request->get('unlock_time'),
				'max_image_size'        => $request->get('max_image_size'),
			]);

			// Check if change app debug
			if ($request->get('debug')) {

				Config::write('app', ['debug' => 'true']);

			}else{

				Config::write('app', ['debug' => 'false']);

			}

			// Update recaptcha keys
			Config::write('captcha', [
				'siteKey'   => $request->get('captcha_sitekey'),
				'secretKey' => $request->get('captcha_secretkey'),
			]);

			// success
			return back()->with('success', 'Congratulations! Settings has been successfully updated.');

		}
	}

}