<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Response;
use Carbon\Carbon;

/**
 * ReportController
 */

class ReportController extends Controller
{

	function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Report Ad
	 */
	public function report(Request $request)
	{
		// Check Ajax request
		if ($request->ajax()) {
			
			// Get Ad ID
			$ad_id = $request->get('ad_id');
			
			// Check if exists
			$ad    = DB::table('ads')->where('ad_id', $ad_id)
									 ->where('status', 1)
									 ->where('is_trashed', 0)
								     ->first();

			if ($ad) {
				
				// Get user ID
				$user_id = Auth::id();

				// Don't report your own ads
				if ($ad->user_id == $user_id) {
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_cannot_report_this_ad'), 
					);

					return Response::json($response);
				}

				// Check if already reported
				$report = DB::table('notifications_reports')->where('user_id', $user_id)->where('ad_id', $ad_id)->first();

				if ($report) {
					
					// Already reported
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_already_reported_ad'), 
					);

					return Response::json($response);

				}else{

					// Report Ad
					DB::table('notifications_reports')->insert([
						'ad_id'      => $ad_id,
						'user_id'    => $user_id,
						'created_at' => Carbon::now(),
					]);

					// Success
					$response = array(
						'status' => 'success', 
						'msg'    => __('return/success.lang_ad_reported'), 
					);

					return Response::json($response);

				}

			}else{

				// Not found
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_ad_not_found') 
				);

				return Response::json($response);

			}

		}
	}

	/**
	 * Report Comment
	 */
	public function comment(Request $request)
	{
		// Check Ajax request
		if ($request->ajax()) {
			
			// Get Comment ID
			$comment_id = $request->get('comment_id');
			
			// Check if exists
			$comment    = DB::table('comments')->where('id', $comment_id)->first();

			if ($comment) {
				
				// Get user ID
				$user_id = Auth::id();

				// Check if already reported
				$report = DB::table('notifications_reports_comments')->where('user_id', $user_id)->where('comment_id', $comment_id)->first();

				if ($report) {
					
					// Already reported
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_already_reported_comment'), 
					);

					return Response::json($response);

				}else{

					// Check if report his comments
					if ($user_id == $comment->user_id) {
						// Error
						$response = array(
							'status' => 'error', 
							'msg'    => __('return/error.lang_cannot_report_this_comment'), 
						);
						return Response::json($response);
					}

					// Report Ad
					DB::table('notifications_reports_comments')->insert([
						'comment_id' => $comment_id,
						'user_id'    => $user_id,
						'created_at' => Carbon::now(),
					]);

					// Success
					$response = array(
						'status' => 'success', 
						'msg'    => __('return/success.lang_comment_reported'), 
					);

					return Response::json($response);

				}

			}else{

				// Not found
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_comment_not_found'), 
				);

				return Response::json($response);

			}

		}
	}

}