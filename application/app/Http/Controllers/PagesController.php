<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Protocol;
use SEO;
use SEOMeta;
use Helper;
use Theme;

class PagesController extends Controller
{
    public $theme = '';
    
    function __construct()
    {
        $this->theme = Theme::get();
    }

    /**
     * Show Page
     */
    public function show(Request $request, $slug)
    {
    	// Check Slug
    	$page = DB::table('pages')->where('page_slug', $slug)->first();

    	if ($page) {
    		

            // Get Tilte && Description
            $title      = Helper::settings_general()->title;
            $long_desc  = Helper::settings_seo()->description;
            $keywords   = Helper::settings_seo()->keywords;

            // Manage SEO
            SEO::setTitle($page->page_name.' | '.$title);
            SEO::setDescription($long_desc);
            SEO::opengraph()->setUrl(Protocol::home());
            SEOMeta::addKeyword([$keywords]);

    		// Show Page
    		return view($this->theme.'.pages.show')->with('page', $page);

    	}else{

    		// Return 404 Page
    		return abort(404);

    	}
    }
}
