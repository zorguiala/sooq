<?php

namespace App\Http\Controllers\Account\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use SEO;
use SEOMeta;
use Helper;
use Profile;
use Theme;

/**
* FeedbackController class
*/
class FeedbackController extends Controller
{
	public $theme = '';

	function __construct()
	{
		$this->middleware('auth');
		$this->theme = Theme::get();
	}

	/**
	 * Get Feedback
	 */
	public function feedback()
	{
		// Get user id
		$user_id = Auth::id();

		// check store
		$store   = DB::table('stores')->where('owner_id', $user_id)->first();

		if ($store) {
			
			// Get feedback
			$feedback = DB::table('stores_feedback')->where('store', $store->username)->orderBy('id', 'desc')->paginate(10);

			// send data
			$data = array(
				'feedback' => $feedback, 
				'store'    => $store, 
			);

			// Mark as Read
			DB::table('stores_feedback')->where('store', $store->username)->update([
				'is_read' => 1
			]);

			// Get Tilte && Description
			$title      = Helper::settings_general()->title;
			$long_desc  = Helper::settings_seo()->description;
			$keywords   = Helper::settings_seo()->keywords;
            // Manage SEO
            SEO::setTitle($store->title.' '.__('title.lang_feedback').' | '.$title);
            SEO::setDescription($long_desc);
            SEOMeta::addKeyword([$keywords]);

			return view($this->theme.'.account.store.feedback')->with($data);

		}else{
			// Not found
            return redirect('/')->with('error', __('return/error.lang_you_dont_have_store'));
		}
	}

	/**
	 * Delete Feedback
	 */
	public function delete(Request $request, $id)
	{
		// Get user id
		$user_id = Auth::id();

		// Get store
		$store = Profile::hasStore($user_id);

		if ($store) {
			
			// Check feedback
			$feedback = DB::table('stores_feedback')->where('id', $id)->where('store', $store->username)->first();

			if ($feedback) {
				
				// Delete feedback
				DB::table('stores_feedback')->where('id', $id)->delete();

				// Success
				return redirect('/account/store/feedback')->with('success', __('return/success.lang_feedback_deleted'));

			}else{

				// Not found
				return redirect('/account/store/feedback')->with('error', __('return/error.lang_feedback_not_found'));

			}

		}else{
			// Not found
            return redirect('/')->with('error', __('return/error.lang_you_dont_have_store'));
		}
	}

}