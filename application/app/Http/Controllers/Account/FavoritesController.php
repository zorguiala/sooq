<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use Validator;
use Response;
use App\Models\Ad;
use Protocol;
use SEO;
use SEOMeta;
use Helper;
use Theme;

/**
* FavoritesController class
*/
class FavoritesController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Add add to favorites
	 */
	public function add_ad(Request $request)
	{
		// Check ajax request
		if ($request->ajax()) {

			// Get Ad id
			$ad_id = $request->get('ad_id');

			// check if ad exists 
			$ad = Ad::where('ad_id', $ad_id)->where('status', 1)->where('is_trashed', 0)->first();

			if ($ad) {

				// Get user id
				$user_id = Auth::id();

				// You cannot add your ads to your favorite list
				if ($ad->user_id == $user_id) {
					// Error
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_cannot_add_your_ads_to_favorite'), 
					);

					return Response::json($response);
				}

				// Check if already in favorites list
				$already_saved = DB::table('favorites')->where('ad_id', $ad_id)->where('user_id', $user_id)->first();

				if ($already_saved) {
					// Already in list
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_ad_alread_in_favorite'), 
					);

					return Response::json($response);
				}

				// Add ad to favorites
				DB::table('favorites')->insert([
					'ad_id'      => $ad_id, 
					'user_id'    => $user_id, 
					'owner'      => $ad->user_id, 
					'created_at' => Carbon::now(), 
					'updated_at' => Carbon::now(),
				]);

				// Update Ad likes
				Ad::where('ad_id', $ad_id)->increment('likes');

				// Send notification to user
				DB::table('notifications_likes')->insert([
					'user_id'    => $ad->user_id,
					'ad_id'      => $ad_id,
					'is_read'    => 0,
					'created_at' => Carbon::now(),
				]);

				// success
				$response = array(
					'status' => 'success', 
					'msg'    => __('return/success.lang_added_to_favorite'), 
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
	 * Get user favorites ads
	 */
	public function ads()
	{
		// Get ads
		$ads = DB::table('favorites')->where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(10);

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_favorite_list').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.favorites')->with('ads', $ads);
	}

	/**
	 * Delete Ad from favorite
	 */
	public function delete_ad(Request $request, $id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check if ad exists in favorite
		$favorite = DB::table('favorites')->where('ad_id', $id)->where('user_id', $user_id)->first();

		if ($favorite) {
			
			// Remove from favorite
			DB::table('favorites')->where('ad_id', $id)->where('user_id', $user_id)->delete();

			// Decrement likes
			Ad::where('ad_id', $id)->decrement('likes');

			// Success
			return redirect('/account/favorite/ads')->with('success', __('return/success.lang_removed_from_favorite'));

		}else{
			// Not found
			return redirect('/account/favorite/ads')->with('error', __('return/error.lang_ad_not_found'));
		}
	}

}