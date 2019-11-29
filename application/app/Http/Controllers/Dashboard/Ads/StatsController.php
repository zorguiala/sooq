<?php

namespace App\Http\Controllers\Dashboard\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Helper;
use App\Models\Ad;
use App\Models\Stats;
use Charts;

/**
* StatsController
*/
class StatsController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Ad stats
	 */
	public function stats(Request $request, $ad_id)
	{
		// Check ad id
		$ad = Ad::where('ad_id', $ad_id)->first();

		if ($ad) {

			// Get stats
			$stats     = Stats::where('ad_id', $ad_id)->get();

			// Get Visits
			$visits    = Charts::database($stats, 'line', 'highcharts')
							->title('Ad Visits')
							->elementLabel("Total Visits")
							->responsive(false)
							->dimensions(0,500)
							->lastByDay(7, true);

			// Get Ad Countries
			$countries = Charts::database($stats, 'geo', 'google')
							->title('Countries Map')
							->elementLabel("Visits")
							->responsive(false)
							->dimensions(0,500)
							->colors(['#C5CAE9', '#283593'])
							->groupBy('country');

			// Get Ad Browsers
			$browsers  = Charts::database($stats, 'pie', 'highcharts')
							->title('Top Browsers')
							->responsive(false)
							->dimensions(0,300)
							->groupBy('browserName');
			
			
			// Get Ad Platforms
			$platforms = Charts::database($stats, 'pie', 'highcharts')
							->title('Top Platforms')
							->responsive(false)
							->dimensions(0,300)
							->groupBy('platformName');

			// Other Stats
			$other_stats = Stats::where('ad_id', $ad_id)->orderBy('id', 'desc')->paginate(30);
			
			// Send Data
			$data = array(
				'visits'      => $visits, 
				'countries'   => $countries, 
				'browsers'    => $browsers, 
				'platforms'   => $platforms, 
				'other_stats' => $other_stats, 
			);

			return view('dashboard.ads.stats')->with($data);

		}else{

			// Not found
			return redirect('/dashboard/ads')->with('error', 'Oops! Ad not found.');

		}
	}

	/**
	 * Ad Comments
	 */
	public function comments(Request $request, $ad_id)
	{
		// check ad
		$ad = Ad::where('ad_id', $ad_id)->first();

		if ($ad) {
			
			// Get Comments
			$comments = DB::table('comments')->where('ad_id', $ad_id)->orderBy('id', 'desc')->paginate(30);

			return view('dashboard.ads.comments')->with('comments', $comments);

		}else{
			// Not found
			return redirect('dashboard/ads')->with('error', 'Oops! Ad not found.');
		}
	}

	/**
	 * Ad Offers
	 */
	public function offers(Request $request, $ad_id)
	{
		// Check Ad
		$ad = Ad::where('ad_id', $ad_id)->first();

		if ($ad) {
			
			// Get Offers
			$offers = DB::table('offers')->where('ad_id', $ad_id)->orderBy('id', 'desc')->paginate(30);

			return view('dashboard.ads.offers')->with('offers', $offers);

		}else{
			// Not found
			return redirect('dashboard/ads')->with('error', 'Oops! Ad not found.');
		}
	}

	/**
	 * Ad Messages
	 */
	public function messages(Request $request, $ad_id)
	{
		// Check Ad
		$ad = Ad::where('ad_id', $ad_id)->first();

		if ($ad) {
			
			// Get Offers
			$messages = DB::table('users_mailbox')->where('ad_id', $ad_id)->orderBy('id', 'desc')->paginate(30);

			return view('dashboard.ads.messages')->with('messages', $messages);

		}else{
			// Not found
			return redirect('dashboard/ads')->with('error', 'Oops! Ad not found.');
		}
	}

}