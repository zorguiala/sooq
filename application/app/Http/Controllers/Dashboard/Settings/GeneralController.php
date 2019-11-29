<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Image;
use Config;
use App;
use Carbon\Carbon;
use Protocol;

/**
* GeneralController
*/
class GeneralController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit General Settings
	 */
	public function edit()
	{
		// Get Settings
		$settings = DB::table('settings_general')->where('id', 1)->first();
		
		// Get available hosting services
		$clouds   = array('local', 'amazon');

		// Send data
		$data = array(
			'settings' => $settings, 
			'clouds'   => $clouds, 
		);

		return view('dashboard.settings.general')->with($data);
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array(
			'title'       => 'required', 
			'description' => 'required', 
			'logo'        => 'image|mimes:png,jpg,jpeg|max:1000', 
			'favicon'     => 'image|mimes:png,jpg,jpeg|max:1000', 
			'language'    => 'required|max:2|alpha', 
			'direction'   => 'required|boolean', 
			'cloud'       => 'required|in:local,google,amazon,rackspace,cloudinary', 
			'facebook'    => 'active_url', 
			'twitter'     => 'active_url', 
			'google'      => 'active_url', 
			'android'     => 'active_url', 
			'iphone'      => 'active_url', 
			'windows'     => 'active_url', 
		);

		// Run rules on requested inputs
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {
			
			// Get Inputs values
			$title       = $request->get('title');
			$description = $request->get('description');
			$logo        = $request->file('logo');
			$favicon     = $request->file('favicon');
			$language    = $request->get('language');
			$direction   = $request->get('direction');
			$facebook    = $request->get('facebook');
			$twitter     = $request->get('twitter');
			$google      = $request->get('google');
			$android     = $request->get('android');
			$iphone      = $request->get('iphone');
			$windows     = $request->get('windows');
			$cloud       = $request->get('cloud');

			// Check if request logo
			if ($logo) {
				
				// Delete Old Logo
				if (is_file(public_path().'/uploads/settings/logo/logo.png')) {
					unlink(public_path().'/uploads/settings/logo/logo.png');
				}

				// Upload New Logo
				$logo_name   = 'logo.png';
				
				// Upload Logo
				$upload_logo = Image::make($logo->getRealPath());
				
				// Save Logo
				$upload_logo->save(public_path().'/uploads/settings/logo/'.$logo_name);
				
			}
				
			// Check if request favicon
			if ($favicon) {
				
				// Delete Old Favicon
				if (is_file(public_path().'/uploads/settings/favicon/favicon.png')) {
					unlink(public_path().'/uploads/settings/favicon/favicon.png');
				}

				// Upload New Favicon
				$favicon_name   = 'favicon.png';
				
				// Upload Favicon
				$upload_favicon = Image::make($favicon->getRealPath());

				// Resize Favicon
				$upload_favicon->resize(40, 40);
				
				// Save Favicon
				$upload_favicon->save(public_path().'/uploads/settings/favicon/'.$favicon_name);

			}

			// save changes
			DB::table('settings_general')->where('id', 1)->update([
				'title'        => $title,
				'description'  => $description,
				'logo'         => 'logo.png',
				'favicon'      => 'favicon.png',
				'language'     => $language,
				'default_host' => $cloud,
			]);

			// Update Social Media Links
			Config::write('social', [
				'facebook' => $facebook,
				'twitter'  => $twitter,
				'google'   => $google,
				'android'  => $android,
				'iphone'   => $iphone,
				'windows'  => $windows,
			]);

			// Check site direction
			if ($direction) {
				
				// RTL
				Config::write('app', [
					'rtl'    => true,
					'name'   => $title,
					'locale' => $language,
					'url'    => Protocol::home()
				]);

				// Set Language
                App::setLocale($language);

                // Change Carbon lang
                Carbon::setlocale($language);

			}else{

				// RTL
				Config::write('app', [
					'rtl'    => false,
					'name'   => $title,
					'locale' => $language,
					'url'    => Protocol::home()
				]);

				// Set Language
                App::setLocale($language);

                // Change Carbon lang
                Carbon::setlocale($language);

			}

			// Success
			return redirect('dashboard/settings/general')->with('success', 'Changes has been successfully saved.');

		}else{

			// error
			return redirect('dashboard/settings/general')->withErrors($validator);

		}
	}

}