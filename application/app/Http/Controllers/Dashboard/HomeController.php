<?php



namespace App\Http\Controllers\Dashboard;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Ad;

use App\Models\Stats;

use App\User;

use DB;

use Charts;

use Config;



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

	 * Get Index Page

	 */
	public function get()

	{
        $total_ads      = Ad::count();

		$total_cats     = DB::table('categories')->count();

		$total_stores   = DB::table('stores')->count();

		$total_users    = DB::table('users')->count();

		$total_messages = DB::table('admin_mailbox')->count();

		$total_comments = DB::table('comments')->count();

		$total_views    = DB::table('stats')->count();

		$total_pages    = DB::table('pages')->count();
		



		// Get Ad Visits
//
        $stats = DB::table('stats')->Orderby('created_at', 'desc')->limit(10000)->get();

		$visits    = Charts::database($stats,'line', 'highcharts')

						->title('Ad Visits')

						->elementLabel("Total Visits")

						->responsive(false)

						->dimensions(0,500)
						
						 ->lastByDay(7, true);



		// Get Latest Users

		$latest_users  = User::orderBy('id', 'desc')->take(10)->get();

		$latest_stores = DB::table('stores')->orderBy('id', 'desc')->take(10)->get();


		
    return View('dashboard.index')->with('total_ads',$total_ads)->with('total_cats',$total_cats)->with('total_stores',$total_stores)->with('total_users',$total_users)->with('total_messages',$total_messages)->with('total_comments',$total_comments)->with('total_views', $total_views)->with('total_pages',$total_pages)->with('visits',$visits)->with('latest_users' , $latest_users)->with('latest_stores', $latest_stores)->with('stats', $stats);

	}

	/**

	 * Maintenance Mode

	 */

	public function maintenance()

	{

		// Get Maintenance Status

		$maintenance = DB::table('settings_general')->where('id', 1)->first();



		return view('dashboard.maintenance')->with('maintenance', $maintenance);

	}



	/**

	 * Update Maintenance Mode status

	 */

	public function update_maintenance(Request $request)

	{

		// Get Maintenance Status

		$maintenance = $request->get('maintenance');



		// Check if want to enable maintenance

		if ($maintenance) {

			

			// Generate token

			$token = strtoupper(str_random(70));



			// Write token in maintenance config file

			Config::write('maintenance', [

				'token' => $token

			]); 



			// Update maintenance status

			DB::table('settings_general')->where('id', 1)->update([

				'is_maintenance' => $maintenance

			]);



		}else{



			// Disable maintenance, remove previous token

			Config::write('maintenance', [

				'token' => null

			]); 



			// Update maintenance status

			DB::table('settings_general')->where('id', 1)->update([

				'is_maintenance' => $maintenance

			]);



		}



		// Success

		return redirect('/dashboard/maintenance')->with('success', 'Maintenance mode has been successfully updated.');

	}



}