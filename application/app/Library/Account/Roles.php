<?php

namespace App\Library\Account;

use Auth;
use DB;

/**
* Roles class
*/
class Roles
{

	/**
	 * Check if can pin comment
	 */
	public static function canPin($comment_id, $ad_id)
	{
		// Check if logged in
		if (Auth::check()) {

			// Get user id
			$user_id = Auth::id();

			// Check ad id
			$ad      = DB::table('ads')->where('ad_id', $ad_id)->where('user_id', $user_id)->first();
			
			// Check comment
			$comment = DB::table('comments')->where('id', $comment_id)->where('ad_id', $ad_id)->where('user_id', $user_id)->first();

			if ($ad AND $comment) {
				
				if (($ad->user_id === $comment->user_id) AND ($ad->ad_id === $comment->ad_id)) {
					return TRUE;
				}else{
					return FALSE;
				}

			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}
	}

}