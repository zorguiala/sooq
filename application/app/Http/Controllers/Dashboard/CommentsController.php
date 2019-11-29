<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use Validator;
use DB;
use Helper;
use Auth;

/**
* CommentsController
*/
class CommentsController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}


	/**
	 * Comments Settings
	 */
	public function comments()
	{
		// Get comments
		$comments = DB::table('comments')->orderBy('id', 'desc')->paginate(30);

		return view('dashboard.comments.comments')->with('comments', $comments);
	}

	/**
	 * Delete Comment
	 */
	public function delete(Request $request, $id)
	{
		// Check comment
		$comment = DB::table('comments')->where('id', $id)->first();

		if ($comment) {
			
			// Get auth id
			$user_id = Auth::id();

			// You cannot delete admin comment
			if (($user_id != 1) && ($comment->user_id == 1)) {
				return redirect('/dashboard/comments')->with('error', 'Oops! You cannot delete admin comments');
			}

			// Delete Comment Notifications
			DB::table('notifications_comments')->where('comment_id', $id)->delete();

			// Delete Comment user Notifications
			DB::table('notifications_user_comments')->where('comment_id', $id)->delete();

			// Delete Comment
			DB::table('comments')->where('id', $id)->delete();

			return redirect('/dashboard/comments')->with('success', 'Comment has been successfully deleted.');

		}else{

			// Not Found
			return redirect('/dashboard/comments')->with('error', 'Oops! Comment not found.');

		}
	}

	/**
	 * Active Comment
	 */
	public function active(Request $request, $id)
	{
		// Check comment
		$comment = DB::table('comments')->where('id', $id)->where('status', 0)->first();

		if ($comment) {

			// Active comment
			DB::table('comments')->where('id', $id)->update([
				'status' => 1
			]);

			// Success
			return redirect('/dashboard/comments')->with('success', 'Congratulations! Comment has been successfully updated.');

		}else{
			// Not found
			return redirect('dashboard/comments')->with('error', 'Oops! Comment not found or already active.');
		}

	}

	/**
	 * Inactive Comment
	 */
	public function inactive(Request $request, $id)
	{
		// Check comment
		$comment = DB::table('comments')->where('id', $id)->where('status', 1)->first();

		if ($comment) {

			$user_id = Auth::id();
			// You cannot inactive admin comment
			if (($user_id != 1) && ($comment->user_id == 1)) {
				return redirect('/dashboard/comments')->with('error', 'Oops! You cannot inactive admin comments');
			}

			// Inactive comment
			DB::table('comments')->where('id', $id)->update([
				'status' => 0
			]);

			// Success
			return redirect('/dashboard/comments')->with('success', 'Congratulations! Comment has been successfully updated.');

		}else{
			// Not found
			return redirect('dashboard/comments')->with('error', 'Oops! Comment not found or already inactive.');
		}

	}

	/**
	 * Pin Comment
	 */
	public function pin(Request $request, $id)
	{
		// Check comment
		$comment = DB::table('comments')->where('id', $id)->first();

		if ($comment) {

			// Get Ad Author
			$ad_author = Ad::where('ad_id', $comment->ad_id)->first();

			// Check if author equal this comment user id
			if ($ad_author->user_id != $comment->user_id) {
				
				// Error
				return redirect('/dashboard/comments')->with('error', 'Oops! You cannot pin this comment.');

			}

			// Unpin all other comments
			DB::table('comments')->where('id', '!=', $id)->where('ad_id', $comment->ad_id)->update([
				'is_pinned' => 0 
			]);

			// Pin comment
			DB::table('comments')->where('id', $id)->update([
				'is_pinned' => 1
			]);

			// Success
			return redirect('/dashboard/comments')->with('success', 'Congratulations! Comment has been successfully pinned.');

		}else{
			// Not found
			return redirect('/dashboard/comments')->with('error', 'Oops! Comment not found.');
		}

	}

	/**
	 * Unpin Comment
	 */
	public function unpin(Request $request, $id)
	{
		// Check comment
		$comment = DB::table('comments')->where('id', $id)->first();

		if ($comment) {

			// Unpin comment
			DB::table('comments')->where('id', $id)->update([
				'is_pinned' => 0
			]);

			// Success
			return redirect('/dashboard/comments')->with('success', 'Congratulations! Comment has been successfully unpinned.');

		}else{
			// Not found
			return redirect('dashboard/comments')->with('error', 'Oops! Comment not found.');
		}

	}

	/**
	 * Edit Comment
	 */
	public function edit(Request $request, $id)
	{
		// Check comment
		$comment = DB::table('comments')->where('id', $id)->first();

		if ($comment) {

			// Get user id
			$user_id = Auth::id();

			// You cannot edit admin comment
			if (($user_id != 1) && ($comment->user_id == 1)) {
				return redirect('/dashboard/comments')->with('error', 'Oops! You cannot edit admin comments');
			}

			return view('dashboard.comments.edit')->with('comment', $comment);

		}else{
			// Not found
			return redirect('dashboard/comments')->with('error', 'Oops! Comment not found.');
		}

	}

	/**
	 * Update Comment
	 */
	public function update(Request $request, $id)
	{
		// Check comment
		$comment = DB::table('comments')->where('id', $id)->first();

		if ($comment) {

			// Get user id
			$user_id = Auth::id();
			
			// You cannot edit admin comment
			if (($user_id != 1) && ($comment->user_id == 1)) {
				return redirect('/dashboard/comments')->with('error', 'Oops! You cannot edit admin comments');
			}
			
			// Check comment content
			$validator = Validator::make($request->all(), [
				'content' => 'required'
			]);

			if ($validator->fails()) {
				return redirect('/dashboard/comments')->withErrors($validator);
			}else{

				// Update comment
				DB::table('comments')->where('id', $id)->update([
					'content' => $request->get('content')
				]);

				// Success
				return redirect('/dashboard/comments')->with('success', 'Congratulations! Comment has been successfully updated.');

			}

		}else{
			// Not found
			return redirect('dashboard/comments')->with('error', 'Oops! Comment not found.');
		}

	}

	/**
	 * Read Comment
	 */
	public function read(Request $request, $id)
	{
		// Check comment
		$comment = DB::table('comments')->where('id', $id)->first();

		if ($comment) {

			return view('dashboard.comments.read')->with('comment', $comment);

		}else{
			// Not found
			return redirect('dashboard/comments')->with('error', 'Oops! Comment not found.');
		}
	}

}