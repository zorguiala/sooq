<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Response;
use App\Models\Ad;
use Helper;
use Carbon\Carbon;
use SEO;
use SEOMeta;
use Protocol;
use Purifier;
use Theme;

/**
* MessagesController class
*/
class MessagesController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Get Messages
	 */
	public function inbox()
	{
		// Get username
		$username = Auth::user()->username;

		// Get user messages
		$messages = DB::table('users_mailbox')->where('msg_to', $username)->orderBy('id', 'desc')->paginate(10);

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_messages').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.messages')->with('messages', $messages);
	}

	/**
	 * Send Message about ad
	 */
	public function create(Request $request)
	{
		// check if ajax request
		if ($request->ajax()) {

			// Make Rules 
			$rules = array(
				'subject'    => 'required', 
				'message'    => 'required', 
				'show_email' => 'required|boolean', 
				'show_phone' => 'required|boolean', 
			);

			// Make validation
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				// error
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_something_went_wrong'), 
				);
				return Response::json($response);
			}

			// Get user ID
			$user_id = Auth::id();
			
			// Get Ad ID
			$ad_id = $request->get('ad_id');

			// Check if ad exists
			$ad = Ad::where('ad_id', $ad_id)->where('status', 1)->first();

			if ($ad) {
				
				// Cannot send yourself message
				if ($ad->user_id == $user_id) {
					// Not found
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_cannot_send_yourself_messages'), 
					);
					return Response::json($response);
				}

				// Get Inputs details
				$subject    = $request->get('subject');
				$message    = $request->get('message');
				$msg_from   = Auth::user()->username;
				$msg_to     = Helper::username_by_id($ad->user_id);
				$show_email = $request->get('show_email');
				$show_phone = $request->get('show_phone');

				// Check if already sent this message
				$already_msg = DB::table('users_mailbox')->where('msg_from', $msg_from)->where('ad_id', $ad_id)->where('subject', $subject)->first();

				if ($already_msg) {
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_already_sent_same_message'), 
					);
					return Response::json($response);
				}

				// Send message
				DB::table('users_mailbox')->insert([
					'ad_id'      => $ad_id,
					'msg_from'   => $msg_from,
					'msg_to'     => $msg_to,
					'email'      => Auth::user()->email,
					'phone'      => Auth::user()->phone,
					'show_email' => $show_email,
					'show_phone' => $show_phone,
					'subject'    => $subject,
					'message'    => $message,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				]);

				// Not found
				$response = array(
					'status' => 'success', 
					'msg'    => __('return/success.lang_message_sent'), 
				);
				return Response::json($response);

			}else{
				// Not found
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_ad_not_found'), 
				);
				return Response::json($response);
			}

		}
	}

	/**
	 * Read Message
	 */
	public function read(Request $request, $id)
	{	
		// Get username
		$username = Auth::user()->username;
		
		// Check message
		$message  = DB::table('users_mailbox')->where('msg_to', $username)->where('id', $id)->first();

		if ($message) {
			
			// Mark as read
			DB::table('users_mailbox')->where('id', $id)->update([
				'is_read' => 1
			]);

			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle(__('title.lang_read_message').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			return view($this->theme.'.account.inbox.read')->with('message', $message);

		}else{
			// Not found
			return redirect('/account/inbox')->with('error', __('return/error.lang_message_not_found'));
		}
	}

	/**
	 * Delete Message
	 */
	public function delete(Request $request, $id)
	{
		// Get username
		$username = Auth::user()->username;
		
		// Check message
		$message  = DB::table('users_mailbox')->where('msg_to', $username)->where('id', $id)->first();

		if ($message) {
			
			// Delete Message
			DB::table('users_mailbox')->where('id', $id)->delete();

			return redirect('/account/inbox')->with('success', __('return/success.lang_message_deleted'));

		}else{
			// Not found
			return redirect('/account/inbox')->with('error', __('return/error.lang_message_not_found'));
		}
	}

	/**
	 * Reply message
	 */
	public function reply(Request $request)
	{
		// Get username && ad id
		$msg_from = $request->get('to');
		$ad_id    = $request->get('ad');
		
		// Get Online username
		$msg_to   = Auth::user()->username;
		
		// check message
		$message  = DB::table('users_mailbox')->where('ad_id', $ad_id)->where('msg_to', $msg_to)->where('msg_from', $msg_from)->first();

		if ($message) {
			
			// send data
			$data = array(
				'ad_id'    => $ad_id, 
				'msg_from' => $msg_from, 
				'msg_to'   => $msg_to, 
				'message'  => $message, 
			);

			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle(__('title.lang_reply_message').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			// Reply
			return view($this->theme.'.account.inbox.reply')->with($data);

		}else{
			// Not found
			return redirect('/account/inbox')->with('error', __('return/error.lang_user_not_send_you_any_message'));
		}
	}

	/**
	 * Send Reply message
	 */
	public function sendreply(Request $request)
	{
		// Get username && ad id
		$msg_from = $request->get('to');
		$ad_id    = $request->get('ad');
		
		// Get Online username
		$msg_to   = Auth::user()->username;
		
		// check message
		$message  = DB::table('users_mailbox')->where('ad_id', $ad_id)->where('msg_to', $msg_to)->where('msg_from', $msg_from)->first();

		if ($message) {

			// Make rules
			$rules = array(
				'subject'    => 'required', 
				'message'    => 'required', 
				'show_phone' => 'required|boolean', 
				'show_email' => 'required|boolean', 
			);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				// Error
				return back()->with('error', __('return/error.lang_something_went_wrong'));
			}else{

				// Get inputs
				$subject    = $request->get('subject');
				$message    = Purifier::clean($request->get('message'));
				$show_email = $request->get('show_email');
				$show_phone = $request->get('show_phone');

				// send message
				DB::table('users_mailbox')->insert([
					'ad_id'      => $ad_id,
					'msg_from'   => $msg_to,
					'msg_to'     => $msg_from,
					'show_email' => $show_email,
					'show_phone' => $show_phone,
					'email'      => Auth::user()->email,
					'phone'      => Auth::user()->phone,
					'subject'    => $subject,
					'message'    => $message,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				]);

				// Message sent
				return redirect('/account/inbox')->with('success', __('return/success.lang_message_sent'));

			}

		}else{
			// Not found
			return redirect('/account/inbox')->with('error', __('return/error.lang_user_not_send_you_any_message'));
		}
	}

}