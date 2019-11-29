<?php

namespace App\Http\Controllers\Dashboard\Inbox;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
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
	 * Get stores messages
	 */
	public function messages()
	{
		// Messages
		$messages = DB::table('stores_feedback')->orderBy('id', 'desc')->paginate('30');
		return view('dashboard.inbox.stores')->with('messages', $messages);
	}

	/**
	 * Read Message
	 */
	public function read(Request $request, $id)
	{
		// Check message
		$message = DB::table('stores_feedback')->where('id', $id)->first();

		if ($message) {

			return view('dashboard.inbox.store_read')->with('message', $message);

		}else{
			// Not found
			return redirect('/dashboard/messages/stores')->with('error', 'Oops! Message not found.');
		}
	}

	/**
	 * Delete Message
	 */
	public function delete(Request $request, $id)
	{
		// Check message
		$message = DB::table('stores_feedback')->where('id', $id)->first();

		if ($message) {
			
			// Delete Message
			DB::table('stores_feedback')->where('id', $id)->delete();

			// success
			return redirect('/dashboard/messages/stores')->with('succes', 'Message has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/messages/stores')->with('error', 'Oops! Message not found.');
		}
	}

}