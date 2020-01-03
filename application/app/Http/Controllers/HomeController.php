<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\User;
use App\Models\Stats;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use DB;
use Helper;
use Protocol;
use SEO;
use SEOMeta;
use IP;
use Firewall;
use Profile;
use Theme;
use Config;

class HomeController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('install');
        $this->theme = Theme::get();
	}
    
	/**
	 * Home Page
	 */

	public function index()
	{
	    
		// Get Ads
		$latest_ads     = Ad::where('status', 1)->where('is_archived', 0)->where('is_trashed', 0)->orderBy('id', 'desc')->take(16)->get();
        // set time calculator 
	     foreach ($latest_ads as &$value) {
		    $date  = time();
		    $time = strtotime($value->created_at);
            $diff = $date-$time;
            $days = floor($diff/(60*60*24));
            $hours = floor($diff/(60*60));
            $minu = floor($diff/(60));
            $month = floor($diff/(30*60*60*24));
            $value->user_name = User::select('first_name','last_name')->where('id', $value->user_id)->get();
            
            if ($month > 0) {
                $value->timeleft ="قبل ".$month." شهر";
            } elseif ($days > 0) {
               $value->timeleft ="قبل ".$days." يوم";
                
            } elseif ($hours > 0) {
                $value->timeleft ="قبل ".$hours." ساعه";
            }elseif ($minu > 0) {
                $value->timeleft ="قبل ".$minu."دقيقه";
            }
        }

		// Get featured ads
		$featured_ads   = Ad::where('status', 1)->where('is_archived', 0)->where('is_trashed', 0)->where('is_featured', 1)->orderByRaw('RAND()')->take(30)->get();
		
		        // set time calculator 
	     foreach ($featured_ads as &$value) {
		    $date  = time();
		    $time = strtotime($value->created_at);
            $diff = $date-$time;
            $days = floor($diff/(60*60*24));
            $hours = floor($diff/(60*60));
            $minu = floor($diff/(60));
            $month = floor($diff/(30*60*60*24));
            $value->user_name = User::select('first_name','last_name')->where('id', $value->user_id)->get();
            
            if ($month > 0) {
                $value->timeleft ="قبل ".$month." شهر";
            } elseif ($days > 0) {
               $value->timeleft ="قبل ".$days." يوم";
                
            } elseif ($hours > 0) {
                $value->timeleft ="قبل ".$hours." ساعه";
            }elseif ($minu > 0) {
                $value->timeleft ="قبل ".$minu."دقيقه";
            }
        }
		
		
		// Get Countries
		// $countries      = Country::all();
		
		// Get Random 12 countries
		// $rand_countries = Country::orderByRaw('RAND()')->take(12)->get();
		
		// Get Quick Stats
		// $total_ads      = Ad::count();
		// $total_views    = Stats::count();
		// $total_stores   = DB::table('stores')->count();
		// $total_users    = User::count();
		
		// // Get GEO Settings
		// $settings_geo  = Helper::settings_geo();

		// // Check if this site config for a international
		// if ($settings_geo->is_international) {

		// 	$countries = Country::all();

		// }else{

		// 	// Get States
		// 	$countries = Country::where('id', $settings_geo->default_country)->get();

		// }

		// $states    = State::where('country_id', $settings_geo->default_country)->get();
		// $cities    = City::where('state_id', $settings_geo->default_state)->get();

		// send data
		$data = array(
			'latest_ads'     => $latest_ads, 
			'featured_ads'   => $featured_ads,
			// 'countries'      => $countries,
			// 'cities'         => $cities,
			// 'rand_countries' => $rand_countries,
			// 'states'         => $states,
			// 'total_ads'      => $total_ads,
			// 'total_views'    => $total_views,
			// 'total_stores'   => $total_stores,
			// 'total_users'    => $total_users,
			// 'settings_geo'   => $settings_geo,
		);

		// Get Tilte && Description
		// $title      = Helper::settings_general()->title;
		// $short_desc = Helper::settings_general()->description;
		// $long_desc  = Helper::settings_seo()->description;
		// $keywords   = Helper::settings_seo()->keywords;

		// // Manage SEO
		// SEO::setTitle($title.' | '.$short_desc);
        // SEO::setDescription($long_desc);
        // SEO::opengraph()->setUrl(Protocol::home());
        // SEOMeta::addKeyword([$keywords]);

		// Show Home Page
		return view($this->theme.'.index')->with($data);
	}

	/**
	 * Site is under maintenance
	 */
	public function maintenance()
	{
		// Check maintenance mode
        $settings = DB::table('settings_general')->where('id', 1)->first();

        if ($settings->is_maintenance) {
            
            // Check if want to disable maintenance via token
            $token = request('token');

            if ($token && ($token == config('maintenance.token'))) {
            	
            	// Disable maintenance
            	DB::table('settings_general')->where('id', 1)->update([
					'is_maintenance' => 0
				]);

				// Remove token
				Config::write('maintenance', [
					'token' => null
				]); 

				return redirect('/');

            }

            // Site is under maintenance
            return view($this->theme.'.maintenance');

        }else{

			// Site is working
			return redirect('/');

		}
	}

}
