<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

/**
* PaymentsController
*/
class PaymentsController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Payments Notifications
	 */
	public function payments()
	{
		// Get Notifications
		$notifications = DB::table('notifications_payments')->orderBy('id', 'desc')->paginate(30);

		// Mark as read
		DB::table('notifications_payments')->where('is_read', 0)->update([
			'is_read' => 1
		]);

		return view('dashboard.notifications.payments')->with('notifications', $notifications);
	}

	/**
	 * Delete Notification
	 */
	public function delete(Request $request, $id)
	{
		// Get Notification
		$notification = DB::table('notifications_payments')->where('id', $id)->first();

		if ($notification) {
			
			// Delete
			DB::table('notifications_payments')->where('id', $id)->delete();

			return redirect('/dashboard/notifications/payments')->with('success', 'Notification has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/notifications/payments')->with('error', 'Oops! Notification not found.');
		}
	}

}