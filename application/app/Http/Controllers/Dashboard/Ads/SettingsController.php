<?php



namespace App\Http\Controllers\Dashboard\Ads;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Validator;

use DB;

use Helper;

use App\Models\Ad;



/**

* SettingsController

*/

class SettingsController extends Controller

{

	function __construct()

	{

		$this->middleware('admin');

	}



	/**

	 * Ads Settings

	 */

	public function settings()

	{

		// Get Ads

		$ads = Ad::orderBy('id', 'desc')->paginate(30);



		return view('dashboard.ads.settings')->with('ads', $ads);

	}



}