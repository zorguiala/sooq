<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Image;
use Config;
use Uploader;
use Defender;

/**
* HomeController
*/
class HomeController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit Home Settings
	 */
	public function edit()
	{
		return view('dashboard.settings.home');
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array(
			'video'                => 'active_url', 
			'wallpaper'            => 'image|mimes:png,jpg,jpeg|max:4000', 
		);

		// Run rules on requested inputs
		$validator = Validator::make($request->all(), $rules);

		if (!$validator->fails()) {
			
			// Get Inputs values
			$wallpaper = $request->file('wallpaper');
			$video     = $request->get('video') ? $request->get('video') : null;

			// Check if request wallpaper
			if ($wallpaper) {

				// Upload New Favicon
				$wallpaper_name = strtoupper(str_random(40)).'.jpg';
				
				// Delete Folder Files
				Uploader::deleteFolderFiles(public_path('uploads/home/background/'));
				
				// Upload Favicon
				$up_wallpaper   = Image::make($wallpaper->getRealPath());

				// Encode Image
				$up_wallpaper->encode('jpg', 60);
				
				// Save Favicon
				$up_wallpaper->save(public_path('uploads/home/background/').$wallpaper_name, 60);

				// Update Settings
				Config::write('home', [
					'wallpaper' => $wallpaper_name,
					'video'     => $video
				]);

			}else{

				Config::write('home', [
					'video'     => $video
				]);

			}

			// Success
			return redirect('dashboard/settings/home')->with('success', 'Changes has been successfully saved.');

		}else{

			// error
			return redirect('dashboard/settings/home')->withErrors($validator);

		}
	}

}