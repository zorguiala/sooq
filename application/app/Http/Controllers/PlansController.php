<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Protocol;
use Helper;
use SEO;
use SEOMeta;
use Theme;

/**
* PlansController
*/
class PlansController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
        $this->theme = Theme::get();
	}
	
	/**
	 * Show Plans 
	 */
	public function plans()
	{
		// Get membership settings
		$settings = DB::table('settings_membership')->where('id', 1)->first();

		// Get Default currency
		$currency = DB::table('settings_geo')->where('id', 1)->first();

		// send data
		$data = array(
			'settings' => $settings, 
			'currency' => $currency, 
		);

		// Get Tilte && Description
		$title      = Helper::settings_general()->title;
		$long_desc  = Helper::settings_seo()->description;
		$keywords   = Helper::settings_seo()->keywords;

		// Manage SEO
		SEO::setTitle(__('title.lang_pricing').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home().'/pricing');
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.plans')->with($data);
	}
	
}