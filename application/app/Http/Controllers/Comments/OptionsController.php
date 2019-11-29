<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Carbon\Carbon;
use Helper;
use DB;
use Purifier;
use SEO;
use SEOMeta;
use Protocol;
use Roles;
use Response;
use Theme;

/**
 * OptionsController
 */
class OptionsController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Pin a Comment
	 */
	public function pin(Request $request)
	{

		// Check ajax request
		if ($request->ajax()) {

			// Get Values
			$ad_id      = $request->get('ad_id');
			$comment_id = $request->get('comment_id');

			// Check if has permissions
			if (Roles::canPin($comment_id, $ad_id)) {
				
				// Unpin old comments
				$unpin = DB::table('comments')->where('is_pinned', 1)->update([
					'is_pinned' => 0
				]);

				// Pin new comment
				DB::table('comments')->where('id', $comment_id)->where('ad_id', $ad_id)->update([
					'is_pinned' => 1
				]);

				// Success
				$response = array(
					'status' => 'success', 
					'msg'    => __('return/success.lang_comment_pinned'), 
				);

				return Response::json($response);

			}else{

				// Error
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_something_went_wrong'), 
				);

				return Response::json($response);

			}

		}

	}

	/**
	 * Read Comment
	 */
	public function read(Request $request, $id)
	{
		// Get user ID
		$user_id = Auth::id();

		// Check comments
		$comment = DB::table('comments')->where('id', $id)->where('user_id', $user_id)->where('status', 1)->first();

		if ($comment) {
			
			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle(__('title.lang_read_comment').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			// Found
			return view($this->theme.'.account.comments.read')->with('comment', $comment);

		}else{
			// Not found
			return redirect('/account/comments')->with('error', __('return/error.lang_comment_not_found'));
		}
	}

	/**
	 * Edit comment
	 */
	public function edit(Request $request, $id)
	{
		// Get user ID
		$user_id = Auth::id();

		// Check comments
		$comment = DB::table('comments')->where('id', $id)->where('user_id', $user_id)->where('status', 1)->first();

		if ($comment) {
			
			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle(__('title.lang_edit_comment').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			// Found
			return view($this->theme.'.account.comments.edit')->with('comment', $comment);

		}else{
			// Not found
			return redirect('/account/comments')->with('error', __('return/error.lang_comment_not_found'));
		}
	}

	/**
	 * Update comment
	 */
	public function update(Request $request, $id)
	{
		// Get user ID
		$user_id = Auth::id();

		// Check comments
		$comment = DB::table('comments')->where('id', $id)->where('user_id', $user_id)->where('status', 1)->first();

		if ($comment) {
			
			// Check if insert comment
			$validator = Validator::make($request->all(), [
				'content' => 'required'
			]);	

			if ($validator->fails()) {
				// error
				return back()->withErrors($validator);
			}else{

				// check comment status
				$status = Helper::status(false, true);

				// Update comment
				DB::table('comments')->where('id', $id)->where('user_id', $user_id)->update([
					'content'    => Purifier::clean($request->get('content')),
					'status'     => $status,
					'updated_at' => Carbon::now(),
				]);

				// generate message
				if ($status) {
					$msg = __('return/success.lang_comment_updated');
				}else{
					$msg = __('return/success.lang_comment_updated_need_moderator');
				}

				// Success
				return redirect('/account/comments')->with('success', $msg);

			}

		}else{
			// Not found
			return redirect('/account/comments')->with('error', __('return/error.lang_comment_not_found'));
		}
	}

	/**
	 * Delete comment
	 */
	public function delete(Request $request, $id)
	{
		// Get user ID
		$user_id = Auth::id();

		// Check comments
		$comment = DB::table('comments')->where('id', $id)->where('user_id', $user_id)->first();

		if ($comment) {
			
			// Delete Notifications
			DB::table('notifications_comments')->where('comment_id', $id)->delete();
			DB::table('notifications_user_comments')->where('comment_id', $id)->delete();
			DB::table('notifications_reports_comments')->where('comment_id', $id)->delete();

			// Delete Comment
			DB::table('comments')->where('id', $id)->delete();

			// Sucess
			return back()->with('success', __('return/success.lang_comment_deleted'));

		}else{
			// Not found
			return back()->with('error', __('return/error.lang_comment_not_found'));
		}
	}

}