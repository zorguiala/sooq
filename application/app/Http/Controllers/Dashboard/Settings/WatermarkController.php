<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Helper;
use Image;
use Input;

/**
* WatermarkController
*/
class WatermarkController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get watermarkSettings
	 */
	public function settings()
	{
		// Get Watermark Settings
		$watermark = DB::table('settings_watermark')->where('id', 1)->first();

		return view('dashboard.settings.watermark')->with('watermark', $watermark);
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array(
			'watermark' => 'image|mimes:jpeg,jpg,png', 
			'opacity'   => 'required|in:25,50,75,100', 
			'position'  => 'required|in:top_right,top_left,bottom_right,bottom_left,center', 
			'is_active' => 'required|boolean', 
		);

		// Run rules on requested inputs
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {
			
			// Get Inputs
			$watermark      = Input::file('watermark');
			$position       = Input::get('position');
			$opacity        = Input::get('opacity');
			$is_active      = Input::get('is_active');

			// Save new Settings
			DB::table('settings_watermark')->where('id', 1)->update([
				'opacity'   => $opacity,
				'position'  => $position,
				'is_active' => $is_active,
			]);	

			// Check if upload watermark
			if ($watermark) {
				
				// Generate Watermark Name
				$watermark_name = 'watermark_'.time().'.png';
				
				// Upload Watermark
				$watermark_img  = Image::make($watermark->getRealPath());

				// Run opacity
				$watermark_img->opacity($opacity);

				// Resize Watermark
				$watermark_img->resize(160, 55);
				
				// Save Watermark
				$watermark_img->save(public_path().'/uploads/settings/watermark/'.$watermark_name);

				// Save new water mark
				DB::table('settings_watermark')->where('id', 1)->update([
					'watermark' => $watermark_name
				]);	

			}

			// Success
			return back()->with('success', 'Congratulations! Settings has been successfully updated.');

		}else{

			// Error
			return back()->withInput()->withErrors($validator);

		}
	}

}