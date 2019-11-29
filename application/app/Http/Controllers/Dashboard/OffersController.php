<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

/**
* OffersController
*/
class OffersController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Offers
	 */
	public function offers()
	{
		// Get Offers
		$offers = DB::table('offers')->orderBy('id', 'desc')->paginate(30);

		return view('dashboard.offers')->with('offers', $offers);
	}

	/**
	 * Delete Offer
	 */
	public function delete(Request $request, $id)
	{
		// Check offer
		$offer = DB::table('offers')->where('id', $id)->first();

		if ($offer) {
			
			// Delete Offer
			DB::table('offers')->where('id', $id)->delete();

			// Success
			return redirect('/dashboard/offers')->with('success', 'Offer has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/offers')->with('error', 'Oops! Offer not found.');
		}
	}

}