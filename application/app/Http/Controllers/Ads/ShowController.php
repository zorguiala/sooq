<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use IP;
use Tracker;
use Carbon\Carbon;
use App\Models\Stats;
use App\User;
use QrCode;
use DB;
use Account;
use App\Models\Ad;
use App\Models\Country;
use App\Models\Rating;
use App\Models\Store;
use Protocol;
use SEO;
use SEOMeta;
use OpenGraph;
use Helper;
use Countries;
use Profile;
use Auth;
use Theme;

/**
* ShowController
*/
class ShowController extends Controller
{

	public $theme = '';
	
	function __construct()
	{
        $this->theme = Theme::get();
	}

	/*********** Show Ad Details ************/
	public function show(Request $request, $id)
	{
		// Check ad
		$ad = Ad::where('slug', $id)->first();

		if (!$ad) {
			return redirect('/')->with('error', __('return/error.lang_ad_not_found'));
		}

		// Check Ad Status
		if (Auth::check()) {

			if (!$ad->status && (!Auth::user()->is_admin)) {
				// 404
				return redirect('/')->with('error', __('return/error.lang_ad_not_found'));
			}

		}elseif (!$ad->status) {
			return redirect('/')->with('error', __('return/error.lang_ad_not_found'));
		}

		// Check trashed ads
		if (Auth::check()) {

			// Check if ad is trashed
			if ($ad->is_trashed && (!Auth::user()->is_admin OR Auth::id() != $ad->user_id)) {
				return redirect('/')->with('error', __('return/error.lang_ad_not_found'));
			}

		}else{
			//
			if ($ad->is_trashed) {
				return redirect('/')->with('error', __('return/error.lang_ad_not_found'));
			}
		}

		// Get Ad Owner
		$owner            = $ad->user_id;

		// Get IP Address
		$ip_address       = IP::get();

		// Get User Agent Info
		$agent            = new Agent;

		// Save Stats
		$stats = Stats::where('ip_address', $ip_address)->where('ad_id', $ad->ad_id)->first();

		if (!$stats) {

			// Get Country Name
			$country          = Tracker::ip($ip_address)->country_code();

			// Get City Name
			$city             = Tracker::ip($ip_address)->city();

			// Get Region
			$region           = Tracker::ip($ip_address)->region();

			// Get Referrer
			$referrer         = Tracker::referrer();

			// Get Referrer Keyword
			$referrer_keyword = Tracker::referrer_keyword();

			// Get Browser Name 
			$browserName      = $agent->browser();

			// Get Browser Version 
			$browserVersion   = $agent->version($browserName);

			// Get Platform Name
			$platformName     = $agent->platform();

			// Get Platform Version
			$platformVersion  = $agent->version($platformName);

			// Get Device Name
			$deviceName       = $agent->device();

			// Check if Robot
			if ($agent->isRobot()) {
				$isRobot      = 1;
				// Get Robot Name
				$robotName    = $agent->robot();
			}else{
				$isRobot      = 0;
				$robotName    = null;
			}

			// Check if Phone
			if ($agent->isPhone()) {
				$isPhone      = 1;
			}else{
				$isPhone      = 0;
			}

			// Check if Desktop 
			if ($agent->isDesktop()) {
				$isDesktop    = 1;
			}else{
				$isDesktop    = 0;
			}

			// First Visit @
			$first_visit      = Carbon::now();

			// Last Visit @
			$last_visit       = Carbon::now();
			
			// Add new record
			$new_stats                   = new Stats;
			$new_stats->ad_id            = $ad->ad_id;
			$new_stats->owner            = $owner;
			$new_stats->ip_address       = $ip_address;
			$new_stats->country          = $country;
			$new_stats->region           = $region;
			$new_stats->city             = $city;
			$new_stats->browserName      = $browserName;
			$new_stats->browserVersion   = $browserVersion;
			$new_stats->platformName     = $platformName;
			$new_stats->platformVersion  = $platformVersion;
			$new_stats->deviceName       = $deviceName;
			$new_stats->isRobot          = $isRobot;
			$new_stats->robotName        = $robotName;
			$new_stats->isPhone          = $isPhone;
			$new_stats->isDesktop        = $isDesktop;
			$new_stats->referrer         = $referrer;
			$new_stats->referrer_keyword = $robotName;
			$new_stats->created_at       = $first_visit;
			$new_stats->updated_at       = $last_visit;
			$new_stats->save();

			// add new view
			Ad::where('ad_id', $ad->ad_id)->increment('views');

		}else{
			// Update Last visit
			Stats::where('ip_address', $ip_address)->where('ad_id', $ad->ad_id)->update([
				'updated_at' => Carbon::now()
			]);
		}

		// Check if affiliate link
		if (!is_null($ad->affiliate_link)) {
			
			return redirect($ad->affiliate_link);

		}
		
		// Generate Qr Code
		$qrCode         = QrCode::encoding('UTF-8')->size(300)->generate(Protocol::home().'/listing/'.$ad->slug);

		// Check if phone is hidden
		$getUser = User::where('id', $ad->user_id)->first();

		// Generate QR Code to make call
		if (!$getUser->phone_hidden) {
			$callQRCode = QrCode::format('svg')->size(200)->generate('tel:'.$getUser->phone);
		}else{
			$callQRCode = false;
		}
		
		// Get Pinned Comment
		$pinned_comment = DB::table('comments')->where('ad_id', $ad->ad_id)->where('status', 1)->where('is_pinned', 1)->first();
		
		// Get Comments
		$comments       = DB::table('comments')->where('ad_id', $ad->ad_id)->where('status', 1)->where('is_pinned', 0)->orderBy('id', 'desc')->paginate(10);

		// Get Related Ads
		$related_ads = Ad::where('ad_id', '!=', $ad->ad_id)
						   ->where('title', 'like', '%'.$ad->title.'%')
						   ->orWhere(function ($query) use ($ad) {
				                $query->where('description', 'like', '%'.$ad->description.'%');
				                $query->where('ad_id', '!=', $ad->ad_id);
								$query->where('status', 1);
								$query->where('is_archived', 0);
								$query->where('is_trashed', 0);
				            })
						   ->orWhere(function ($query) use ($ad) {
				                $query->where('category', $ad->category);
				                $query->where('ad_id', '!=', $ad->ad_id);
								$query->where('status', 1);
								$query->where('is_archived', 0);
								$query->where('is_trashed', 0);
				            })
						   ->where('ad_id', '!=', $ad->ad_id)
						   ->where('status', 1)
						   ->where('is_archived', 0)
						   ->where('is_trashed', 0)
						   ->orderByRaw('RAND()')
						   ->take(6)
						   ->get();

		// Check if user have store
		$store = Store::where('owner_id', $ad->user_id)->where('status', true)->first();

		if ($store) {
			
			// Get Ad reviews
			$reviews = Rating::where('ad_id', $ad->ad_id)->where('store_id', $store->id)->where('is_approved', true);
			
			$average_rating = Helper::rating_average($ad->ad_id, $store->id);

			$total_reviews = $reviews->get();

		}else{
			$reviews        = null;
			$total_reviews  = null;
			$average_rating = null;

		}

		$data = array(
			'ad'             => $ad,  
			'getUser'        => $getUser,  
			'related_ads'    => $related_ads,  
			'qrCode'         => $qrCode, 
			'callQRCode'     => $callQRCode, 
			'pinned_comment' => $pinned_comment, 
			'comments'       => $comments,
			'total_reviews'  => $total_reviews,
			'average_rating' => $average_rating,
			'total_comments' => $comments->total(),
			'isPhone'        => $agent->isPhone()
		);

		// Get Tilte && Description
		$title           = Helper::settings_general()->title;
		$keywords        = Helper::settings_seo()->keywords;
		
		// Create Seo Description
		$seo_description = substr(trim(preg_replace('/\s+/', ' ', $ad->description)), 0, 150);

		/*
		* Config SEO settings
		*/

        // Get image size
      
        

		// General SEO settings
		SEOMeta::setTitle($ad->title.' | '.$title);
        SEOMeta::setDescription(strip_tags($ad->description));
        SEOMeta::addKeyword([$keywords]);

        // Schema.org markup for Google+
        SEOMeta::addMeta('name', $ad->title.' | '.$title, 'itemprop');
        SEOMeta::addMeta('description', strip_tags($ad->description), 'itemprop');
        if (!empty($ad->photos)):
            SEOMeta::addMeta('image', Helper::ad_first_image($ad->ad_id, $ad->images_host), 'itemprop');
        endif;

        // Twitter Card data
        SEOMeta::addMeta('twitter:card', 'product', 'name');
        SEOMeta::addMeta('twitter:site', $title, 'name');
        SEOMeta::addMeta('twitter:title', $ad->title.' | '.$title, 'name');
        SEOMeta::addMeta('twitter:description', strip_tags($ad->description), 'name');
        SEOMeta::addMeta('twitter:creator', Profile::full_name($ad->user_id), 'name');
        if (!empty($ad->photos)):
            SEOMeta::addMeta('twitter:image', Helper::ad_first_image($ad->ad_id, $ad->images_host), 'name');
        endif;
        SEOMeta::addMeta('twitter:data1', $ad->price.' '.$ad->currency, 'name');
        SEOMeta::addMeta('twitter:label1', 'Price', 'name');

        // Open Graph data
        SEOMeta::addMeta('og:title', $ad->title.' | '.$title, 'property');
        SEOMeta::addMeta('og:type', 'product', 'property');
        SEOMeta::addMeta('og:url', Protocol::home().'/listing/'.$ad->slug, 'property');
        // if (!empty($ad->photos)):
        //     SEOMeta::addMeta('og:image', Helper::ad_first_image($ad->ad_id, $ad->images_host), 'property');
        //     SEOMeta::addMeta('og:image:width', $width, 'property');
        //     SEOMeta::addMeta('og:image:height', $height, 'property');
        // endif;
        SEOMeta::addMeta('og:description', strip_tags($ad->description), 'property');
        SEOMeta::addMeta('og:site_name', $title, 'property');
        SEOMeta::addMeta('fb:app_id', config('services.facebook.client_id'), 'property');


        if ($agent->isPhone()) {
        	
        	// Phone view
        	return view($this->theme.'.ads.show_mobile')->with($data);

        }else{

        	// Computer view
			return view($this->theme.'.ads.show')->with($data);

		}
	}

	/**
	 * Browse All Ads
	 */
	public function browse(Request $request)
	{
		// Get filters
		$date      = $request->get('date');
		$status    = $request->get('status');
		$condition = $request->get('condition');

		// Check Date
		if ($date) {

			switch ($date) {
				case 'today':
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereRaw('Date(created_at) = CURDATE()')->orderBy('id', 'desc')->paginate(30);
					break;
				case 'yesterday':
					$yesterday = date("Y-m-d", strtotime( '-1 days' ) );
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereDate('created_at', $yesterday )->orderBy('id', 'desc')->paginate(30);
					break;
				case 'week':
					$fromDate = Carbon::now()->subDays(8)->format('Y-m-d');
					$tillDate = Carbon::now()->format('Y-m-d');
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereBetween( DB::raw('date(created_at)'), [$fromDate, $tillDate] )->orderBy('id', 'desc')->paginate(30);
					break;
				case 'month':
					$fromDate = Carbon::now()->subDays(31)->format('Y-m-d');
					$tillDate = Carbon::now()->format('Y-m-d');
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereBetween( DB::raw('date(created_at)'), [$fromDate, $tillDate] )->orderBy('id', 'desc')->paginate(30);
					break;
				case 'year':
					$fromDate = Carbon::now()->subDays(366)->format('Y-m-d');
					$tillDate = Carbon::now()->format('Y-m-d');
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereBetween( DB::raw('date(created_at)'), [$fromDate, $tillDate] )->orderBy('id', 'desc')->paginate(30);
					break;
				
				default:
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->orderBy('id', 'desc')->paginate(30);
					break;
			}

		}elseif ($status) {
			
			switch ($status) {
				case 'featured':
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->where('is_featured', 1)->orderBy('id', 'desc')->paginate(30);
					break;
				case 'normal':
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->where('is_featured', 0)->orderBy('id', 'desc')->paginate(30);
					break;
				
				default:
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->orderBy('id', 'desc')->paginate(30);
					break;
			}

		}elseif ($condition) {
			
			switch ($condition) {
				case 'used':
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->where('is_used', 1)->orderBy('id', 'desc')->paginate(30);
					break;
				case 'new':
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->where('is_used', 0)->orderBy('id', 'desc')->paginate(30);
					break;
				
				default:
					$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->orderBy('id', 'desc')->paginate(30);
					break;
			}

		}else{

			// Get Ads
			$ads = Ad::where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->orderBy('id', 'desc')->paginate(30);

		}

		// Get Tilte && Description
		$title      = Helper::settings_general()->title;
		$long_desc  = Helper::settings_seo()->description;
		$keywords   = Helper::settings_seo()->keywords;

		// Manage SEO
		SEO::setTitle(__('title.lang_browse_all').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home().'/browse');
        SEOMeta::addKeyword([$keywords]);
		foreach ($ads as &$value) {
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
		return view($this->theme.'.ads.browse')->with('ads', $ads);
	}

	/**
	 * Random Ad
	 */
	public function random()
	{
		// Get a random ad
		$ad = Ad::where('status', 1)->where('is_archived', 0)->where('is_trashed', 0)->orderByRaw('RAND()')->first();

		// Check if ad exists
		if ($ad) {
			
			return redirect('listing/'.$ad->slug);

		}else{
			// Not ad found
			return redirect('/')->with('error', __('return/error.lang_no_ads_right_now'));
		}

	}

	/**
	 * Redirect Ad to new seo link
	 */
	public function redirect(Request $request, $ad_id)
	{
		// Check if ad exists
		$ad = Ad::where('ad_id', $ad_id)->where('status', 1)->where('is_trashed', 0)->first();

		if ($ad) {
			return redirect('listing/'.$ad->slug);
		}else{
			// Not found
			return redirect('/');
		}
	}

	/**
	* Get All Countries
	*/
	public function countries()	
	{

		// Check if international site
		if (!Helper::settings_geo()->is_international) {
			return redirect('/browse');
		}
		
		// Get Countries
		$countries = Country::all();

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('update_two.lang_browse_by_countries').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home().'/countries');
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.ads.browse.countries', compact('countries'));

	}

	/**
	* Browse By Country 
	*/
	public function country($code)	
	{

		// Check if international site
		if (!Helper::settings_geo()->is_international) {
			return redirect('/browse');
		}
		
		// Check country code
		$country = Country::where('sortname', $code)->first();

		if ($country) {
			
			// Get Ads by country
			$ads = Ad::where('country', $code)->where('status', 1)->where('is_archived', 0)->where('is_trashed', 0)->orderBy('id', 'desc')->paginate(30);

			// Send array
			$data = array(
				'ads' => $ads, 
				'country' => $country, 
			);

			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle($country->name. ' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home().'/browse/country/'.$code);
	        SEOMeta::addKeyword([$keywords]);

			return view($this->theme.'.ads.browse.country', $data);

		}else{

			// Country not found
			return redirect('/')->with('error', __('update_two.lang_country_not_found'));

		}

	}

}