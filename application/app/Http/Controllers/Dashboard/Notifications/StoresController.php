<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

/**
* StoresController
*/
class StoresController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Stores Notifications
	 */
	public function stores()
	{
		// Get Notifications
		$notifications = DB::table('notifications_stores')->orderBy('id', 'desc')->paginate(30);

		// Mark as read
		DB::table('notifications_stores')->where('is_read', 0)->update([
			'is_read' => 1
		]);

		return view('dashboard.notifications.stores')->with('notifications', $notifications);
	}

	/**
	 * Delete Notification
	 */
	public function delete(Request $request, $id)
	{
		// Get Notification
		$notification = DB::table('notifications_stores')->where('id', $id)->first();

		if ($notification) {
			
			// Delete
			DB::table('notifications_stores')->where('id', $id)->delete();

			return redirect('/dashboard/notifications/stores')->with('success', 'Notification has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/notifications/stores')->with('error', 'Oops! Notification not found.');
		}
	}

}