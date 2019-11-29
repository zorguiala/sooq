<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Image;
use Config;

/**
* SEOController
*/
class SEOController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit SEO Settings
	 */
	public function edit()
	{
		// Get Settings
		$settings = DB::table('settings_seo')->where('id', 1)->first();

		return view('dashboard.settings.seo')->with('settings', $settings);
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array(
			'description' => 'required', 
			'keywords'    => 'required', 
			'is_sitemap'  => 'required', 
		);

		// Validate
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			// Error
			return back()->withErrors($validator);
		}else{

			// Get Inputs Values
			$description      = $request->get('description');
			$keywords         = $request->get('keywords');
			$google_analytics = $request->get('google_analytics');
			$is_sitemap       = $request->get('is_sitemap');
			$header_code      = $request->get('header_code');

			// Update Settings
			DB::table('settings_seo')->where('id', 1)->update([
				'description'      => $description,
				'keywords'         => $keywords,
				'google_analytics' => $google_analytics,
				'is_sitemap'       => $is_sitemap,
				'header_code'      => $header_code,
			]);

			// Success
			return back()->with('success', 'Settings has been successfully updated.');

		}
	}

}