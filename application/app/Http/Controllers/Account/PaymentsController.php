<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use DB;
use Auth;
use Helper;
use SEO;
use SEOMeta;
use Protocol;
use Theme;

/**
* PaymentsController class
*/
class PaymentsController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Get Account Upgrade Payments
	 */
	public function account_upgrade()
	{
		// Get user id
		$user_id = Auth::id();

		// Get payments
		$payments = Subscription::where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_account_upgrade_history').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.payments.account')->with('payments', $payments);
	}

	/**
	 * Get Ads Upgrade Payments
	 */
	public function ads_upgrade()
	{
		// Get user id
		$user_id  = Auth::id();

		// Get payments
		$payments = DB::table('ads_payments')->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_ads_upgrade_history').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.payments.ads')->with('payments', $payments);
	}

}