<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Config;
use Image;
use Uploader;
use Protocol;

/**
* FooterController
*/
class FooterController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit Footer Settings
	 */
	public function edit()
	{
		// Get Footer Settings
		return view('dashboard.settings.footer');
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array(
			'mailchip_api_key'    => 'required_with:mailchip_list_id', 
			'mailchip_list_id'    => 'required_with:mailchip_api_key',
			'footer_logo'         => 'image|mimes:jpg,jpeg,png|max:1000',
			'footer_copyright'    => 'required',
			'footer_column_one'   => 'required',
			'footer_column_two'   => 'required',
			'footer_column_three' => 'required',
			'footer_column_four'  => 'required',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			// Error
			return back()->withErrors($validator);
		}else{

			// Get Inputs
			$mailchip_api_key    = $request->get('mailchip_api_key');
			$mailchip_list_id    = $request->get('mailchip_list_id');
			$footer_logo         = $request->file('footer_logo');
			$footer_copyright    = $request->get('footer_copyright');
			$footer_column_one   = $request->get('footer_column_one');
			$footer_column_two   = $request->get('footer_column_two');
			$footer_column_three = $request->get('footer_column_three');
			$footer_column_four  = $request->get('footer_column_four');

			// Check if request new footer
			if ($footer_logo) {
				
				// Get footer logo folder
				$logo_folder    = public_path().'/uploads/settings/logo/footer/';
				
				// Delete Old footer logo
				Uploader::deleteFolderFiles($logo_folder);
				
				// Upload Logo
				$foote_logo_img = Image::make($footer_logo->getRealPath());
				
				// Save Logo
				$foote_logo_img->save(public_path().'/uploads/settings/logo/footer/logo.png');

			}

			// Update Footer Settings
			Config::write('footer', [
				'copyright'    => $footer_copyright,
				'column_one'   => $footer_column_one,
				'column_two'   => $footer_column_two,
				'column_three' => $footer_column_three,
				'column_four'  => $footer_column_four,
			]);

			// Update newsletter settings
			Config::write('newsletter', [
				'apiKey'               => $mailchip_api_key,
				'lists.subscribers.id' => $mailchip_list_id,
			]);

			// Update Page terms url
			Config::write('pages', [
				'terms'               => Protocol::home().'/page/terms'
			]);

			// Success
			return back()->with('success', 'Congratulations! Footer settings has been successfully updated.');
		}			
	}

}