<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Helper;
use SEO;
use SEOMeta;
use Protocol;
use Theme;

/**
* CommentsController class
*/
class CommentsController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Get Comments
	 */
	public function comments()
	{
		// Get user id
		$user_id  = Auth::id();
		
		// Get Comments
		$comments = DB::table('comments')->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_manage_comments').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.comments.comments')->with('comments', $comments);
	}

}