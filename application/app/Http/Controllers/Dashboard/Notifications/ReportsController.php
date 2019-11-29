<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

/**
* ReportsController
*/
class ReportsController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Ads Reports Notifications
	 */
	public function ads()
	{
		// Get Notifications
		$notifications = DB::table('notifications_reports')->orderBy('id', 'desc')->paginate(30);

		// Mark as read
		DB::table('notifications_reports')->where('is_read', 0)->update([
			'is_read' => 1
		]);

		return view('dashboard.notifications.reports_ads')->with('notifications', $notifications);
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