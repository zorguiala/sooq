<?php

namespace App\Http\Controllers\Dashboard\Inbox;

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
	 * Get users messages
	 */
	public function messages()
	{
		// Messages
		$messages = DB::table('users_mailbox')->orderBy('id', 'desc')->paginate('30');
		return view('dashboard.inbox.users')->with('messages', $messages);
	}

	/**
	 * Read Message
	 */
	public function read(Request $request, $id)
	{
		// Get Message
		$message = DB::table('users_mailbox')->where('id', $id)->first();

		if ($message) {
			
			return view('dashboard.inbox.user_read')->with('message', $message);

		}else{
			// Not found
			return redirect('/dashboard/messages/users')->with('error', 'Oops! Message not found.');
		}
	}

	/**
	 * Delete Message
	 */
	public function delete(Request $request, $id)
	{
		// Get Message
		$message = DB::table('users_mailbox')->where('id', $id)->first();

		if ($message) {
			
			// Delete
			DB::table('users_mailbox')->where('id', $id)->delete();

			// Success
			return redirect('/dashboard/messages/users')->with('success', 'Message has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/messages/users')->with('error', 'Oops! Message not found.');
		}
	}

}