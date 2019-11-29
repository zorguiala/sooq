<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

/**
* AdvertisementsController
*/
class AdvertisementsController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit Advertisements
	 */
	public function edit()
	{
		// Get Advertisements
		$advertisements = DB::table('advertisements')->where('id', 1)->first();

		return view('dashboard.advertisements')->with('advertisements', $advertisements);
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Get Inputs values
		$ad_sidebar     = $request->get('ad_sidebar');
		$ad_middle      = $request->get('ad_middle');
		$search_sidebar = $request->get('search_sidebar');

		// Update Settings
		DB::table('advertisements')->where('id', 1)->update([
			'ad_sidebar'     => $ad_sidebar,
			'ad_middle'      => $ad_middle,
			'search_sidebar' => $search_sidebar,
		]);

		// Success
		return back()->with('success', 'Advertisements has been successfully updated.');
	}

}