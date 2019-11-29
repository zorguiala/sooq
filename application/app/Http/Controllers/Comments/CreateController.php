<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Response;
use TextManager;
use Carbon\Carbon;
use Helper;
use DB;
use Profile;
use App\Models\Ad;
use App\User;
use App\Notifications\NewComment;
use Purifier;
use Protocol;

/**
 * CreateController
 */
class CreateController extends Controller
{
	
	function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * New Comment
	 */
	public function create(Request $request)
	{
		// Check if Ajax Request
		if ($request->ajax()) {

			// Check if user logged in
			if (Auth::check()) {
				
				// Make Rules
				$rules = array(
					'comment' => 'required|max:500', 
				);

				// Make Rules on Inputs
				$validator = Validator::make($request->all(), $rules);

				// Check if Validator Passes
				if ($validator->fails()) {
					
					// Send error response
					$response = array(
						'status' => 'error',
						'msg'    => __('return/error.lang_add_comment_error'),
					);

					return Response::json($response);

				}else{

					// Get Ad Id
					$ad_id = $request->get('ad_id');
					
					// Check ad
					$ad    = Ad::where('ad_id', $ad_id)->where('status', 1)->first();

					if (!$ad) {
						// Send error response
						$response = array(
							'status' => 'error',
							'msg'    => __('return/error.lang_ad_not_found'),
						);

						return Response::json($response);
					}

					// Get user ID
					$user_id    = Auth::id();

					if (Profile::hasStore($user_id)) {
						// Store name
						$fullname  = Profile::hasStore($user_id)->title;
						$user_link = Protocol::home().'/store/'.Profile::hasStore($user_id)->username;
						$trusted   = 'trusted-badge';
					}else{
						// Get User Full Name
						$fullname  = Auth::user()->first_name." ".Auth::user()->last_name;
						$user_link = '#';
						$trusted   = null;
					}

					// Status
					$status     = Helper::status(false, true);

					// Get Comment Value
					$comment    = Purifier::clean($request->input('comment'));

					// Comment Created At
					$created_at = Carbon::now();

					// Last Update At
					$updated_at = Carbon::now();

					// Is Pinned
					$is_pinned  = 0;

					// Check for double comments
					$double_cm = DB::table('comments')->where('ad_id', $ad_id)->where('content', $comment)->first();

					if ($double_cm) {
						
						// Send error response
						$response = array(
							'status' => 'error',
							'msg'    => __('return/error.lang_alraedy_sent_comment'),
						);

						return Response::json($response);

					}

					// Insert Comment
					$insert_comment = DB::table('comments')->insertGetId([
						'ad_id'      => $ad_id,
						'user_id'    => $user_id,
						'content'    => $comment,
						'is_pinned'  => $is_pinned,
						'status'     => $status,
						'created_at' => $created_at,
						'updated_at' => $updated_at,
					]);

					// Get Message
					if ($status) {
						$msg = __('return/success.lang_comment_created');
					}else{

						$msg = __('return/success.lang_comment_under_reviewing');
					}

					// Don't send notification if post owner equal auth id
					if ($ad->user_id != $user_id) {

						// Send email notification to Ad Owner
						$ad_owner = User::where('id', $ad->user_id)->first();
						$ad_owner->notify(new NewComment($ad->ad_id));

						// Send notification via database
						DB::table('notifications_user_comments')->insert([
							'comment_id' => $insert_comment,
							'user_id'    => $ad_owner->id,
							'ad_id'      => $ad_id,
							'created_at' => $created_at,
						]);

					}

					// Comment Added
					$response   = array(
						'status'     => 'success',
						'user_image' => Profile::picture($user_id),
						'fullname'   => $fullname,
						'trusted'    => $trusted,
						'user_link'  => $user_link,
						'commentid'  => $insert_comment,
						'cm_date'    => Helper::date_ago(Carbon::now()),
						'content'    => $comment,
						'msg'        => $msg,
					);

					return Response::json($response);

				}

			}

		}
	}
	
}