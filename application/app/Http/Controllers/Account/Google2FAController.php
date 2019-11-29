<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Google2FA\Google2FA;
use Theme;
use Helper;
use SEOMeta;
use SEO;
use Protocol;

class Google2FAController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	* Settings Two Factor Authentication
	*/
	public function get()
	{
		/*$google2fa = new Google2FA();
    
		return $google2fa->generateSecretKey();*/

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle('Two Factor Authentication | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.2fa');
	}
}
