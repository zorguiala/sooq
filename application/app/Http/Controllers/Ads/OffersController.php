<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\OfferAccepted;
use App\Notifications\OfferRefused;
use Carbon\Carbon;
use DB;
use Validator;
use Response;
use Auth;
use Helper;
use App\Models\Ad;
use App\User;
use SEO;
use SEOMeta;
use Protocol;
use Theme;

/**
* OffersController
*/
class OffersController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 *  Make New Offer
	 */
	public function make(Request $request)
	{
		// Check ajax request
		if ($request->ajax()) {
			
			// Make rules
			$rules = array(
				'price' => 'required', 
				'ad_id' => 'required', 
			);

			// run rules
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				
				// error
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_you_have_to_put_price'), 
				);

				return Response::json($response);

			}else{

				// Get Inputs
				$ad_id = $request->get('ad_id');
				$price = $request->get('price');

				// Check ad
				$ad = Ad::where('ad_id', $ad_id)->where('status', 1)->where('is_trashed', 0)->first();

				if ($ad) {
					
					// Get Variables
					$offer_by    = Auth::id();
					$offer_to    = $ad->user_id;
					$is_accepted = null;
					$created_at  = Carbon::now();
					$updated_at  = Carbon::now();

					// Can't submit yourself offers
					if ($offer_by == $offer_to) {
						// error
						$response = array(
							'status' => 'error', 
							'msg'    => __('return/error.lang_cannot_send_yourself_offers'), 
						);

						return Response::json($response);
					}

					// Check price
					if (!Helper::isCurrency($price)) {
						// error
						$response = array(
							'status' => 'error', 
							'msg'    => __('return/error.lang_price_format_invalid'), 
						);

						return Response::json($response);
					}

					// Check if already submitted the same offer
					$already_offer = DB::table('offers')->where('offer_by', $offer_by)->where('offer_to', $offer_to)->where('ad_id', $ad_id)->where('price', $price)->first();

					if ($already_offer) {
						// error
						$response = array(
							'status' => 'error', 
							'msg'    => __('return/error.lang_already_sent_offer'), 
						);

						return Response::json($response);
					}

					// Make New Offer
					DB::table('offers')->insert([
						'ad_id'       => $ad_id,
						'offer_by'    => $offer_by,
						'offer_to'    => $offer_to,
						'price'       => $price,
						'is_accepted' => $is_accepted,
						'created_at'  => $created_at,
						'updated_at'  => $updated_at,
					]);

					// Success
					$response = array(
						'status' => 'success', 
						'msg'    => __('return/success.lang_offer_submitted'), 
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
	}

	/**
	 * User Offers
	 */
	public function myoffers()
	{
		// Get Offers
		$offers = DB::table('offers')->where('offer_to', Auth::id())->orderBy('id', 'desc')->paginate(10);

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_received_offers').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.offers')->with('offers', $offers);
	}

	/**
	 * Accept Offer
	 */
	public function accept(Request $request, $id)
	{
		// Get user id
		$user_id = Auth::id();
		
		// Check offer
		$offer   = DB::table('offers')->where('id', $id)->where('offer_to', $user_id)->where('is_accepted', null)->first();

		if ($offer) {
			
			// Accept offer
			DB::table('offers')->where('id', $id)->update([
				'is_accepted' => 1
			]);

			// Get offer by user
			$user = User::where('id', $offer->offer_by)->first();

			// Send email to user
            $user->notify(new OfferAccepted($offer->id));

            return redirect('/account/offers')->with('success', __('return/success.lang_offer_accepted'));

		}else{
			// Not found
			return redirect('/account/offers')->with('error', __('return/error.lang_offer_not_found'));
		}
	}

	/**
	 * refuse Offer
	 */
	public function refuse(Request $request, $id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check offer
		$offer = DB::table('offers')->where('id', $id)->where('offer_to', $user_id)->where('is_accepted', null)->first();

		if ($offer) {
			
			// refuse offer
			DB::table('offers')->where('id', $id)->update([
				'is_accepted' => 0
			]);

			// Get offer by user
			$user = User::where('id', $offer->offer_by)->first();

			// Send email to user
            $user->notify(new OfferRefused($offer->id));

            return redirect('/account/offers')->with('success', __('return/success.lang_offer_refused'));

		}else{
			// Not found
			return redirect('/account/offers')->with('error', __('return/error.lang_offer_not_found'));
		}
	}

	/**
	 * Delete Offer
	 */
	public function delete(Request $request, $id)
	{
		// Get user id
		$user_id = Auth::id();

		// Check offer
		$offer = DB::table('offers')->where('id', $id)->where('offer_to', $user_id)->first();

		if ($offer) {
			
			// delete offer
			DB::table('offers')->where('id', $id)->where('offer_to', $user_id)->delete();

            return redirect('/account/offers')->with('success', __('return/success.lang_offer_deleted'));

		}else{
			// Not found
			return redirect('/account/offers')->with('error', __('return/error.lang_offer_not_found'));
		}
	}

}