<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

/**
* AdsController
*/
class AdsController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Ads Notifications
	 */
	public function ads()
	{
		// Get Notifications
		$notifications = DB::table('notifications_ads')->orderBy('id', 'desc')->paginate(30);

		// Mark as read
		DB::table('notifications_ads')->where('is_read', 0)->update([
			'is_read' => 1
		]);

		return view('dashboard.notifications.ads')->with('notifications', $notifications);
	}

	/**
	 * Delete Notification
	 */
	public function delete(Request $request, $id)
	{
		// Get Notification
		$notification = DB::table('notifications_ads')->where('id', $id)->first();

		if ($notification) {
			
			// Delete
			DB::table('notifications_ads')->where('id', $id)->delete();

			return redirect('/dashboard/notifications/ads')->with('success', 'Notification has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/notifications/ads')->with('error', 'Oops! Notification not found.');
		}
	}

}