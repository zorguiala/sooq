<?php

namespace App\Http\Controllers\Dashboard\Inbox;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

/**
* AdminController
*/
class AdminController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get admin messages
	 */
	public function messages()
	{
		// Messages
		$messages = DB::table('admin_mailbox')->orderBy('id', 'desc')->paginate('30');
		return view('dashboard.inbox.admin')->with('messages', $messages);
	}

	/**
	 * Read Message
	 */
	public function read(Request $request, $id)
	{
		// Check message
		$message = DB::table('admin_mailbox')->where('id', $id)->first();

		if ($message) {
			
			// Mark as read
			if (!$message->is_read) {
				
				DB::table('admin_mailbox')->where('id', $id)->update([
					'is_read' => 1
				]);

			}
			return view('dashboard.inbox.admin_read')->with('message', $message);

		}else{
			// Not found
			return redirect('/dashboard/messages/admin')->with('error', 'Oops! Message not found.');
		}
	}

	/**
	 * Delete Message
	 */
	public function delete(Request $request, $id)
	{
		// Check message
		$message = DB::table('admin_mailbox')->where('id', $id)->first();

		if ($message) {
			
			// Delete Message
			DB::table('admin_mailbox')->where('id', $id)->delete();

			// success
			return redirect('/dashboard/messages/admin')->with('succes', 'Message has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/messages/admin')->with('error', 'Oops! Message not found.');
		}
	}

}