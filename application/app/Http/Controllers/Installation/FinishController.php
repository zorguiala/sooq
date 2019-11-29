<?php 

namespace App\Http\Controllers\Installation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Config;
use Auth;
use Uploader;

/**
* FinishController
*/
class FinishController extends Controller
{
	
	/**
	 * Get database info 
	 */
	public function finish()
	{
		// Check if finish section passed
		if (Session::get('finish_passed')) {
			
			return redirect('/');

		}

		return view('install.finish');
	}

	/**
	 * Done installation
	 */
	public function done(Request $request)
	{

		// Get installation folders
		$controllers = app_path('Http/Controllers/Installation');
		$updater     = app_path('Http/Controllers/Update');
		$views       = resource_path('views/install');
		$public      = public_path('installer');
		$updateSQL   = public_path('updater');
		
		// Delete All files
		Uploader::recursiveRemoveDirectory($controllers);
		Uploader::recursiveRemoveDirectory($updater);
		Uploader::recursiveRemoveDirectory($views);
		Uploader::recursiveRemoveDirectory($public);
		Uploader::recursiveRemoveDirectory($updateSQL);

		// Change Session Driver
		Config::write('session', [
			'driver' => 'database'
		]);

		// Change Cache default Store
		Config::write('cache', [
			'default' => 'file'
		]);

		// Login using id 1
		Auth::loginUsingId(1, true);

		return redirect('/')->with('success', 'Congratulations! Your EVEREST Script has been successfully configured.');

	}

	

}