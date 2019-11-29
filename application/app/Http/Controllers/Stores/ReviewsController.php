<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Ad;
use App\Models\Rating;
use Theme;
use SEO;
use Helper;
use SEOMeta;

class ReviewsController extends Controller
{
    public $theme = '';
    
    function __construct()
    {
        $this->theme = Theme::get();
    }

    /**
	* Get ad reviews
    */
    public function reviews(Request $request, $username, $id)
    {
    	// Check store
    	$store = Store::where('username', $username)->where('status', 1)->first();

    	if ($store) {
    		
    		// Check ad
    		$ad = Ad::where('ad_id', $id)->where('user_id', $store->owner_id)->where('status', true)->where('is_trashed', false)->first();

    		if ($ad) {
    			
    			// Ad exists, get reviews
    			$reviews = Rating::where('ad_id', $ad->ad_id)->where('is_approved', true)->paginate(30);

    			// Send data
    			$data = array(
    				'reviews' => $reviews, 
    				'ad'      => $ad, 
    				'store'   => $store, 
    			);

                // Get Tilte && Description
                $title      = Helper::settings_general()->title;
                $long_desc  = Helper::settings_seo()->description;
                $keywords   = Helper::settings_seo()->keywords;

                // Manage SEO
                SEO::setTitle(__('update_three.lang_ad_reviews').' | '.$title);
                SEO::setDescription($long_desc);
                SEOMeta::addKeyword([$keywords]);

    			return view($this->theme.'.stores.reviews', $data);

    		}else{

    			// Ad not found
    			return redirect('/')->with('error', 'Oops! Ad not found.');

    		}

    	}else{

    		// Store not found
    		return redirect('/')->with('error', 'Oops! Store not found.');

    	}
    }
}
