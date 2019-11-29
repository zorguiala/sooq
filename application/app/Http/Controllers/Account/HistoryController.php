<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use SEO;
use SEOMeta;
use Protocol;
use Helper;
use Theme;

/**
* HistoryController class
*/
class HistoryController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Get Login History
	 */
	public function history()
	{
		// Get user email
		$email        = Auth::user()->email;

		// Get failed login
		$failed_login = DB::table('failed_login')->where('email', $email)->orderBy('id', 'desc')->paginate(10);

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_failed_login').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.history')->with('failed_login', $failed_login);
	}

}