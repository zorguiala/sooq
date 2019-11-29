<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

/**
* UsersController
*/
class UsersController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Users Notifications
	 */
	public function users()
	{
		// Get notifications
		$notifications = DB::table('notifications_users')->orderBy('id', 'desc')->paginate(30);

		// Mark Notifications as read
		DB::table('notifications_users')->where('is_read', 0)->update([
			'is_read' => 1
		]);

		return view('dashboard.notifications.users')->with('notifications', $notifications);
	}

	/**
	 * Detele Notification
	 */
	public function delete(Request $request, $id)
	{
		// Check id
		$notification = DB::table('notifications_users')->where('id', $id)->first();

		if ($notification) {
			// Delete it
			DB::table('notifications_users')->where('id', $id)->delete();

			// Success
			return back()->with('success', 'Notification has been successfully deleted.');
		}else{
			// Not found
			return back()->with('error', 'Oops! Notification not found.');
		}
	}

}