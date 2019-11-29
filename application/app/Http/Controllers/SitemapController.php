<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Category;
use Helper;
use Theme;

class SitemapController extends Controller
{
   	public function index()
	{

		// Check if sitemap is active
		if (!Helper::settings_seo()->is_sitemap) {
			return redirect('/');
		}

	 	$ad = Ad::where('status', 1)->where('is_trashed', 0)->orderBy('updated_at', 'desc')->first();

	  	return response()->view(Theme::get().'.sitemap.index', [
	      	'ad' => $ad
	  	])->header('Content-Type', 'text/xml');

	}

	public function ads()
	{

		// Check if sitemap is active
		if (!Helper::settings_seo()->is_sitemap) {
			return redirect('/');
		}

	    $ads = Ad::where('status', 1)->where('is_trashed', 0)->get();
	    return response()->view(Theme::get().'.sitemap.ads', [
	        'ads' => $ads,
	    ])->header('Content-Type', 'text/xml');
	}

	public function categories()
	{

		// Check if sitemap is active
		if (!Helper::settings_seo()->is_sitemap) {
			return redirect('/');
		}

	    $categories = Category::where('is_sub', 1)->get();
	    return response()->view(Theme::get().'.sitemap.categories', [
	        'categories' => $categories,
	    ])->header('Content-Type', 'text/xml');
	}

}
