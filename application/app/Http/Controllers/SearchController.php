<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Redirect;
use DB;
use App\Models\Ad;
use App\Models\Country;
use Helper;
use SEO;
use SEOMeta;
use Protocol;
use Theme;

class SearchController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
        $this->theme = Theme::get();
	}
    
	/**
	 * Search ads
	 */
	public function search(Request $request, Ad $ads)
	{

		// Get Filters
		$q        = $request->get('q');
		$country  = $request->get('country');
		$state    = $request->get('state');
		$city     = $request->get('city');
		$category = $request->get('category');
		$sort     = $request->get('sort');
		$min      = round($request->get('min'));
		$max      = round($request->get('max'));
		$currency = $request->get('currency');

		// Start Time
		$time_start = microtime(true); 

		$ads = $ads->newQuery();

		// Check Keyword
		if (!empty($q)) {
		    $ads->where('title', 'like', '%' . $q . '%')->orWhere('description', 'like', '%' . $q . '%');
		}

		if (Helper::settings_geo()->is_international) {

			// Check country
			if ($country && ($country != "all")) {
			    $ads->where('country', $country);
			}

		}

		// Check State
		if ($state && ($state != "all")) {
		    $ads->where('state', $state);
		}

		// Check city
		if ($city && ($city != "all")) {
		    $ads->where('city', $city);
		}

		// Check Category
		if (is_numeric($category)) {
		    $ads->where('category', $category);
		}

		// Check Sort 'newest'
		if ($sort == "newest") {
		    $ads->latest();
		}

		// Check Sort 'oldest'
		if ($sort == "oldest") {
		    $ads->orderBy('created_at', 'asc');
		}

		// Check Sort 'views'
		if ($sort == "views") {
		    $ads->orderBy('views', 'desc');
		}

		// Check Sort 'likes'
		if ($sort == "rating") {
		    $ads->orderBy('likes', 'desc');
		}

		// Check Sort 'featured'
		if ($sort == "featured") {
		    $ads->where('is_featured', 1);
		}

		// Check Currency
		if (!empty($currency)) {
		    $ads->where('currency', $currency);
		}

		// Check price
		if ($min || $max) {
			// Get the results and return them.
			$results        = $ads->whereBetween('price', [$min, $max])->paginate(30);
		}else{
			// Get the results and return them.
			$results        = $ads->where('status', 1)->where('is_archived', 0)->where('is_trashed', 0)->paginate(30);
		}

		
		
		// End time
		$time_end       = microtime(true);
		
		$execution_time = ($time_end - $time_start);
		
		// Get Countries
		$countries      = Country::all();

		// Get GEO Settings
		$settings_geo   = Helper::settings_geo();

		// Get Tilte && Description
		$title      = Helper::settings_general()->title;
		$long_desc  = Helper::settings_seo()->description;
		$keywords   = Helper::settings_seo()->keywords;

		// Manage SEO
		SEO::setTitle(__('title.lang_search_for').' "'.$q.'" | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home().'/search');
        SEOMeta::addKeyword([$keywords]);

		// Send data
		$data = array(
			'q'              => $q, 
			'country'        => $country, 
			'state'          => $state, 
			'city'           => $city, 
			'category'       => $category, 
			'sort'           => $sort, 
			'min'            => $min, 
			'max'            => $max, 
			'results'        => $results, 
			'totalResults'   => $results->total(), 
			'execution_time' => $execution_time, 
			'countries'      => $countries, 
			'settings_geo'   => $settings_geo, 
		);

		return view($this->theme.'.search')->with($data);


	}

}
