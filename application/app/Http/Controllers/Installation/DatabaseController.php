<?php 

namespace App\Http\Controllers\Installation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use DB;
use Config;

/**
* DatabaseController
*/
class DatabaseController extends Controller
{
	
	/**
	 * Get database info 
	 */
	public function database()
	{
		if (Session::get('database_passed')) {
			
			// Already passed
			return redirect('/install/account')->with('error', 'Oops! You passed the database section.');

		}
		return view('install.database');
	}

	/**
	 * Insert new database
	 */
	public function insert(Request $request)
	{
		// Make rules
		$rules = array(
			'server' => 'required', 
			'dbname' => 'required', 
			'dbuser' => 'required', 
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('install/database')->withErrors($validator)->withInput();

		}else{

			// Get db info
			$server = $request->get('server');
			$dbname = $request->get('dbname');
			$dbuser = $request->get('dbuser');
			$dbpass = $request->get('dbpass');

			// Write db
			Config::write('database', [
				'connections.mysql.host'     => $server,
				'connections.mysql.database' => $dbname,
				'connections.mysql.username' => $dbuser,
				'connections.mysql.password' => $dbpass,
			]);

			// Insert tables
			return redirect('install/database/tables');

		}
	}

	/**
	 * Insert tables
	 */
	public function tables()
	{
		// Check connection
		if (DB::connection()->getPdo()) {
			
			// Get sql file
			$sql_file = public_path('installer/install.sql');

	        // Insert Tables
	        $sql_contents = file_get_contents($sql_file);
	        $sql          = explode(";", $sql_contents);
	        $n            = count ($sql) - 1;

	        for ($i = 0; $i < $n; $i++) {
	            $query  = $sql[$i];

	            $result = DB::statement($query);

	        }

	        // Set Session
			Session::put('database_passed', true);

			// Edit Session driver
			Config::write('session', [
				'driver' => 'database'
			]);

			// Success
			return redirect('install/account')->with('success', 'Database has been successfully configured.');

		}else{

			// Not connected
			return redirect('install/database')->with('error', 'Could not connect to the database.  Please check your configuration.');

		}
	}

}