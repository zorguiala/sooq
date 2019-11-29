<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Config;
use Protocol;

/**
* AuthController
*/
class AuthController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Auth Settings
	 */
	public function edit()
	{
		// Get Settings
		$settings = DB::table('settings_auth')->where('id', 1)->first();

		return view('dashboard.settings.auth')->with('settings', $settings);
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array(
			'need_activation'         => 'required|boolean', 
			'activation_type'         => 'required|in:admin,email,sms', 
			'activation_expired_time' => 'required|numeric', 
			'max_warnings'            => 'required|numeric', 
			'fb_client_id'            => 'required_with:fb_secret', 
			'fb_secret'               => 'required_with:fb_client_id', 
			'tw_client_id'            => 'required_with:tw_secret', 
			'tw_secret'               => 'required_with:tw_client_id', 
			'go_client_id'            => 'required_with:go_client_secret', 
			'go_client_secret'        => 'required_with:go_client_id', 
			'in_client_id'            => 'required_with:in_client_secret', 
			'in_client_secret'        => 'required_with:in_client_id', 
			'pi_client_id'            => 'required_with:pi_client_secret', 
			'pi_client_secret'        => 'required_with:pi_client_id', 
			'li_client_id'            => 'required_with:li_client_secret', 
			'li_client_secret'        => 'required_with:li_client_id', 
			'vk_client_id'            => 'required_with:vk_client_secret', 
			'vk_client_secret'        => 'required_with:vk_client_id', 
		);

		// Validate
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			// Error
			return back()->withErrors($validator);
		}else{

			// Get Inputs
			$need_activation         = $request->get('need_activation');
			$activation_type         = $request->get('activation_type');
			$activation_expired_time = $request->get('activation_expired_time');
			$max_warnings            = $request->get('max_warnings');
			$fb_client_id            = $request->get('fb_client_id');
			$fb_secret               = $request->get('fb_secret');
			$tw_client_id            = $request->get('tw_client_id');
			$tw_secret               = $request->get('tw_secret');
			$go_client_id            = $request->get('go_client_id');
			$go_client_secret        = $request->get('go_client_secret');
			$in_client_id            = $request->get('in_client_id');
			$in_client_secret        = $request->get('in_client_secret');
			$pi_client_id            = $request->get('pi_client_id');
			$pi_client_secret        = $request->get('pi_client_secret');
			$li_client_id            = $request->get('li_client_id');
			$li_client_secret        = $request->get('li_client_secret');
			$vk_client_id            = $request->get('vk_client_id');
			$vk_client_secret        = $request->get('vk_client_secret');

			// Update Settings
			DB::table('settings_auth')->where('id', 1)->update([
				'need_activation'         => $need_activation,
				'activation_type'         => $activation_type,
				'activation_expired_time' => $activation_expired_time,
				'max_warnings'            => $max_warnings,
			]);

			// Get home url
			$home_url = Protocol::home();

			// Rewrite Social Login Info
			Config::write('services', [
				'facebook.client_id'      => $fb_client_id,
				'facebook.client_secret'  => $fb_secret,
				'facebook.redirect'       => $home_url.'/auth/facebook/callback',
				'twitter.client_id'       => $tw_client_id,
				'twitter.client_secret'   => $tw_secret,
				'twitter.redirect'        => $home_url.'/auth/twitter/callback',
				'google.client_id'        => $go_client_id,
				'google.client_secret'    => $go_client_secret,
				'google.redirect'         => $home_url.'/auth/google/callback',
				'instagram.client_id'     => $in_client_id,
				'instagram.client_secret' => $in_client_secret,
				'instagram.redirect'      => $home_url.'/auth/instagram/callback',
				'pinterest.client_id'     => $pi_client_id,
				'pinterest.client_secret' => $pi_client_secret,
				'pinterest.redirect'      => $home_url.'/auth/pinterest/callback',
				'linkedin.client_id'      => $li_client_id,
				'linkedin.client_secret'  => $li_client_secret,
				'linkedin.redirect'       => $home_url.'/auth/linkedin/callback',
				'vkontakte.client_id'     => $vk_client_id,
				'vkontakte.client_secret' => $vk_client_secret,
				'vkontakte.redirect'      => $home_url.'/auth/vk/callback',
			]);

			// Success
			return back()->with('success', 'Settings has been successfully updated.');

		}
	}

}