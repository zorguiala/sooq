<?php

namespace App\Http\Controllers\Ads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Rating;
use App\Models\Store;
use Auth;
use Response;
use Theme;
use Validator;

class ReviewsController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	* Create new review
	*/
	public function create(Request $request)
	{
		// Check if ajax request
		if ($request->ajax()) {
			
			// Make Rules
			$rules = array(
				'stars' => 'required|in:1,2,3,4,5', 
				'ad_id' => 'required|exists:ads,ad_id', 
			);

			// Make Validation
			$validator = Validator::make($request->all(), $rules);

			if ($validator->passes()) {

				// Get Inputs values
				$comment = $request->get('comment');
				$stars   = $request->get('stars');
				$ad_id   = $request->get('ad_id');

				// Check if rating already exists
				if (Rating::where('ad_id', $ad_id)->where('user_id', Auth::id())->first()) {
					
					// error
					$response = array(
						'status' => 'error',
						'msg'    => __('update_three.lang_already_submitted_review')
					);
					return Response::json($response);

				}

				// Get ad
				$ad = Ad::where('ad_id', $ad_id)->where('status', true)->where('is_featured', true)->where('is_trashed', false)->first();

				if ($ad) {

					// Check if owner of this ad have an active store
					$store = Store::where('owner_id', $ad->user_id)->where('status', true)->first();

					if ($store) {
						
						// Store owner cannot create reviews for his own ads
						if ($store->owner_id == Auth::id()) {
							
							// Error
							$response = array(
								'status' => 'error', 
								'msg'    => __('update_three.lang_cant_create_reviews_for_own_ads')
							);
							return Response::json($response);

						}

						// Ad exists, create review
						Rating::create([
							'ad_id'    => $ad_id,
							'user_id'  => Auth::id(),
							'store_id' => $store->id,
							'comment'  => $comment,
							'rating'   => $stars,
						]);

						// create new notification

						// Send notification to user

						// Success rating
						$response = array(
							'status' => 'success', 
							'msg'    => __('update_three.lang_review_created_successfully')
						);
						return Response::json($response);

					}else{

						// Does not have a store
						$response = array(
							'status' => 'error', 
							'msg'    => __('update_three.lang_user_doesnt_have_store') 
						);
						return Response::json($response);

					}

				}

			}else{

				// error
				$response = array(
					'status' => 'errors', 
					'errors' => $validator->getMessageBag()->toArray()
				);

				return Response::json($response);

			}

		}
	}

}
