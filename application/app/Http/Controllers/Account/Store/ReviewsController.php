<?php

namespace App\Http\Controllers\Account\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Store;
use Auth;
use Theme;
use Helper;
use SEO;
use SEOMeta;
use Protocol;

class ReviewsController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	* Get Reviews
	*/
	public function reviews(Rating $reviews)
	{
		// Get User store
		$store = Store::where('owner_id', Auth::id())->where('status', true)->first();

		if ($store) {
			
			// Store exists, get reviews
			$r = $reviews->where('store_id', $store->id)->paginate(30);

			// Get Tilte && Description
            $title      = Helper::settings_general()->title;
            $long_desc  = Helper::settings_seo()->description;
            $keywords   = Helper::settings_seo()->keywords;

            // Manage SEO
            SEO::setTitle(__('update_three.lang_manage_reviews').' | '.$title);
            SEO::setDescription($long_desc);
            SEOMeta::addKeyword([$keywords]);

			return view($this->theme.'.account.store.reviews', compact('r'));

		}else{

			// Store does not exists
			return redirect('upgrade')->with('error', 'Oops! You need to upgrade your account first.');

		}
	}

	/**
	* Publish Review
	*/
	public function publish(Request $request, $id, Rating $review, Store $store)
	{
		// Get User ID
		$user_id = Auth::id();

		// Get Store
		$store = $store->where('owner_id', $user_id)->where('status', true)->first();

		if ($store) {
			
			// Check review
			$review = $review->where('store_id', $store->id)->where('id', $id)->where('is_approved', false)->first();

			if ($review) {
				
				// Active review
				$review->update([
					'is_approved' => true
				]);

				// Success
				return redirect('account/store/reviews')->with('success', 'Review has been successfully published.');

			}else{

				// Review does not exists
				return redirect('/account/store/reviews')->with('error', 'Oops! Review does not exists.');

			}

		}else{

			// Does not have store
			return redirect('/upgrade')->with('error', 'Oops! Please upgrade your account.');

		}
	}

	/**
	* Hide Review
	*/
	public function hide(Request $request, $id, Rating $review, Store $store)
	{
		// Get User ID
		$user_id = Auth::id();

		// Get Store
		$store = $store->where('owner_id', $user_id)->where('status', true)->first();

		if ($store) {
			
			// Check review
			$review = $review->where('store_id', $store->id)->where('id', $id)->where('is_approved', true)->first();

			if ($review) {
				
				// Hide review
				$review->update([
					'is_approved' => false
				]);

				// Success
				return redirect('account/store/reviews')->with('success', 'Review has been successfully hidden.');

			}else{

				// Review does not exists
				return redirect('/account/store/reviews')->with('error', 'Oops! Review does not exists.');

			}

		}else{

			// Does not have store
			return redirect('/upgrade')->with('error', 'Oops! Please upgrade your account.');

		}
	}
}
