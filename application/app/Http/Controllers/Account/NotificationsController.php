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
* NotificationsController class
*/
class NotificationsController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Redirect
	 */
	public function redirect()
	{
		return redirect('/account/notifications/ads');
	}

	/**
	 * Get Ads Notifications
	 */
	public function ads()
	{
		// Get user id
		$user_id = Auth::id();

		// Get ads notifications
		$notifications = DB::table('notifications_ads_accepted')->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);

		// Mark as read
		DB::table('notifications_ads_accepted')->where('user_id', $user_id)->update([
			'is_read' => 1
		]);	

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_notifications_ads').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.notifications.ads')->with('notifications', $notifications);
	}

	/**
	 * Delete Notification
	 */
	public function delete_ad(Request $request, $id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check notification
		$notification = DB::table('notifications_ads_accepted')->where('id', $id)->where('user_id', $user_id)->first();

		if ($notification) {
			
			// Delete notification
			$notification = DB::table('notifications_ads_accepted')->where('id', $id)->where('user_id', $user_id)->delete();

			// Success
			return redirect('/account/notifications/ads')->with('success', __('return/success.lang_notification_deleted'));

		}else{
			// Not found
			return redirect('/account/notifications/ads')->with('error', __('return/error.lang_notification_not_found'));
		}
	}

	/**
	 * Get Comments Notifications
	 */
	public function comments()
	{
		// Get user id
		$user_id       = Auth::id();
		
		$notifications = DB::table('notifications_user_comments')->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);

		// Mark as read
		DB::table('notifications_user_comments')->where('user_id', $user_id)->update([
			'is_read' => 1
		]);	

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_notifications_comments').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.
			'.account.notifications.comments')->with('notifications', $notifications);
	}

	/**
	 * Delete Notification
	 */
	public function delete_comment(Request $request, $id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check notification
		$notification = DB::table('notifications_user_comments')->where('id', $id)->where('user_id', $user_id)->first();

		if ($notification) {
			
			// Delete notification
			$notification = DB::table('notifications_user_comments')->where('id', $id)->where('user_id', $user_id)->delete();

			// Success
			return redirect('/account/notifications/comments')->with('success', __('return/success.lang_notification_deleted'));

		}else{
			// Not found
			return redirect('/account/notifications/comments')->with('error', __('return/error.lang_notification_not_found'));
		}
	}

	/**
	 * Likes Notifications
	 */
	public function likes()
	{
		// Get user id
		$user_id       = Auth::id();

		// Get notifications
		$notifications = DB::table('notifications_likes')->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);

		// Mark as read
		DB::table('notifications_likes')->where('user_id', $user_id)->update([
			'is_read' => 1
		]);	

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_notifications_likes').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.notifications.likes')->with('notifications', $notifications);

	}

	/**
	 * Delete Notification
	 */
	public function delete_like(Request $request, $id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check notification
		$notification = DB::table('notifications_likes')->where('id', $id)->where('user_id', $user_id)->first();

		if ($notification) {
			
			// Delete notification
			$notification = DB::table('notifications_likes')->where('id', $id)->where('user_id', $user_id)->delete();

			// Success
			return redirect('/account/notifications/likes')->with('success', __('return/success.lang_notification_deleted'));

		}else{
			// Not found
			return redirect('/account/notifications/likes')->with('error', __('return/error.lang_notification_not_found'));
		}
	}

	/**
	 * Likes Notifications
	 */
	public function warnings()
	{
		// Get user id
		$user_id       = Auth::id();

		// Get notifications
		$notifications = DB::table('notifications_warnings')->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);

		// Mark as read
		DB::table('notifications_warnings')->where('user_id', $user_id)->update([
			'is_read' => 1
		]);	

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_notifications_warning').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.notifications.warnings')->with('notifications', $notifications);

	}

}