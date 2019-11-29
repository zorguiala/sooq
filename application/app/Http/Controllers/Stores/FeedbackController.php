<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Carbon\Carbon;
use Response;
use Profile;
use Spam;
use Purifier;
use App\Models\Store;

/**
 * FeedbackController
 */

class FeedbackController extends Controller
{

	/**
	 * Contact Store
	 */
	public function send(Request $request, $username)
	{

		// Check if request ajax
		if ($request->ajax()) {

			// Check if store exists
			$store = Store::where('username', $username)->where('status', 1)->first();

			if ($store) {

				// Check if want to send himself message
				if (Auth::check()) {
					if (Profile::hasStore(Auth::id()) && (Profile::hasStore(Auth::id())->username == $username)) {
						$response = array(
							'status' => 'error', 
							'msg'    => __('return/error.lang_cannot_send_yourself_messages')
						);

						return Response::json($response);
					}
				}

				// Make rules
				$rules = array(
					'fullname' => 'required', 
					'email'    => 'required|email', 
					'phone'    => 'required', 
					'subject'  => 'required|max:150', 
					'message'  => 'required|max:300', 
				);

				// Make validation
				$validator = Validator::make($request->all(), $rules);

				if ($validator->fails()) {
					// Response Error
					$response = array(
						'status' => 'errors', 
						'errors' => $validator->getMessageBag()->toArray()
					);

					return Response::json($response);
				}

				// Get inputs values
				$name    = $request->get('fullname');
				$email   = $request->get('email');
				$phone   = $request->get('phone');
				$subject = $request->get('subject');
				$message = Purifier::clean($request->get('message'));

				// Check if spam email
				if (Spam::email($email)) {
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_system_detected_spam_email')
					);

					return Response::json($response);
				}

				// Check if already send this feedback
				$check_feed = DB::table('stores_feedback')->where('email', $email)->where('phone', $phone)->where('subject', $subject)->first();

				if ($check_feed) {
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_already_sent_same_message')
					);

					return Response::json($response);
				}

				// Send feedback
				DB::table('stores_feedback')->insert([
					'name'       => $name,
					'email'      => $email,
					'phone'      => $phone,
					'subject'    => $subject,
					'message'    => $message,
					'store'      => $username,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				]);

				
				// Response Success
				$response = array(
					'status' => 'success', 
					'msg'    => __('return/success.lang_message_sent'), 
				);

				return Response::json($response);

			}else{

				// 404 not found
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_store_not_found'), 
				);

				return Response::json($response);

			}

		}
	}

}