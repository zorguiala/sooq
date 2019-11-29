<?php 

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Random;
use DB;
use App\Models\Ad;
use App\Models\State;
use App\Models\City;
use Uploader;
use Config;

/**
* StartController
*/
class StartController extends Controller
{

	/**
	 * Config Tables
	 */
	public function start()
	{
		// Check connection
		if (DB::connection()->getPdo()) {
			
			// Get sql file
			$sql_file = public_path('updater/update.sql');

	        // Insert Tables
	        $sql_contents = file_get_contents($sql_file);
	        $sql          = explode(";", $sql_contents);
	        $n            = count ($sql) - 1;

	        for ($i = 0; $i < $n; $i++) {
	            $query  = $sql[$i];

	            $result = DB::statement($query);

	        }

			// Success
			return redirect('update/finish');

		}
	}
	
	/**
	 * Config 
	 */
	public function config()
	{
		// Nothing here right now :)
	}

	/**
	 * Finish
	 */
	public function finish()
	{
		// Delete Files
		$controllers = app_path('Http/Controllers/Update');
		$public      = public_path('updater');
		
		// Delete All files
		Uploader::recursiveRemoveDirectory($controllers);
		Uploader::recursiveRemoveDirectory($public);

		// Edit Session driver
		Config::write('session', [
			'driver' => 'database'
		]);

		// Change Cache default Store
		Config::write('cache', [
			'default' => 'file'
		]);

		return redirect('/');
	}

	

}