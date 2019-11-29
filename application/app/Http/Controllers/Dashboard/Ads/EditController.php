<?php

namespace App\Http\Controllers\Dashboard\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use DB;
use Helper;
use Input;
use App\Models\Ad;
use Redirect;
use Uploader;
use EverestCloud;
use Carbon\Carbon;
use Auth;

/**
* EditController
*/
class EditController extends Controller
{

	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit Ad
	 */
	public function edit(Request $request, $ad_id)
	{
		// Check ad
		$ad = Ad::where('ad_id', $ad_id)->first();

		if ($ad) {
			
			// Get user id
			$user_id = Auth::id();

			// Check ad owner
			if (($user_id != 1) && ($ad->user_id == 1)) {
				
				// You cannot edit admin ads
				return redirect('/dashboard/ads')->with('error', 'Oops! You cannot edit this ad.');

			}

			return view('dashboard.ads.edit')->with('ad', $ad);

		}else{
			// Not found
			return redirect('/dashboard/ads')->with('error', 'Oops! Ad not found.');
		}
	}

	/**
	 * Update Ad
	 */
	public function update(Request $request, $ad_id)
	{
		// Check ad
		$ad = Ad::where('ad_id', $ad_id)->first();

		if ($ad) {
			
			// Get user id
			$user_id = Auth::id();

			// Check ad owner
			if (($user_id != 1) && ($ad->user_id == 1)) {
				
				// You cannot edit admin ads
				return redirect('/dashboard/ads')->with('error', 'Oops! You cannot edit this ad.');

			}

			// Make Rules
			$rules = array(
				'title'       => 'required|max:100', 
				'description' => 'required', 
				'negotiable'  => 'required|boolean',
				'condition'   => 'required|boolean', 
				'status'      => 'required|boolean', 
				'featured'    => 'required|boolean', 
				'archived'    => 'required|boolean', 
				'description' => 'required', 
				'currency'    => 'required|exists:currencies,code', 
				'youtube'     => 'active_url', 
				'category'    => 'required|numeric|exists:categories,id',
			    'affiliate_link' => 'active_url',
			);

			// Make rules on inputs
			$validator = Validator::make($request->all(), $rules);

			// Check if validation fails
			if ($validator->fails()) {
				
				// Error
				return Redirect::back()->withErrors($validator);

			}else{

				// Get Inputs values
				$title       = $request->get('title');
				$description = $request->get('description');
				$category    = $request->get('category');
				$price       = $request->get('price');
				$negotiable  = $request->get('negotiable');
				$condition   = $request->get('condition');
				$status      = $request->get('status');
				$featured    = $request->get('featured');
				$archived    = $request->get('archived');
				$currency    = $request->get('currency');
				$photos      = $request->file('photos');

				// Check Price
				if (!Helper::isCurrency($price)) {
					// Error price
					return back()->with('error', 'Oops! Sale Price format is not valid.');
				}

				// Has Store
				$youtube        = $request->get('youtube') ? : NULL ;
				$affiliate_link = $request->get('affiliate_link') ? : NULL;
				$regular_price  = $request->get('regular_price') ? : NULL;

				// Check Regular Price
				if ($regular_price && !Helper::isCurrency($regular_price)) {
					return back()->with('error', 'Oops! Regular Price format is not valid.');
				}

				// Update Ad
				Ad::where('ad_id', $ad_id)->update([
					'title'          => $title, 
					'affiliate_link' => $affiliate_link, 
					'regular_price'  => $regular_price, 
					'description'    => $description, 
					'price'          => $price, 
					'category'       => $category, 
					'negotiable'     => $negotiable, 
					'status'         => $status, 
					'is_used'        => $condition, 
					'is_featured'    => $featured, 
					'is_archived'    => $archived, 
					'currency'       => $currency, 
					'youtube'        => $youtube, 
					'updated_at'     => Carbon::now(),
				]);

				if ($photos && $ad->photos != '') {

					// Count Photos
					$count_photos = count($photos);

					// Replace Photos
					$is_uploaded = Uploader::edit($photos, $ad_id);

					// Check if photos uploaded
					if ($is_uploaded) {
						
						// Get Previews Photos
						$previews          = implode('||', $is_uploaded['previews_array']);

						// Get Thumbnails Photos
						$thumbnails        = implode('||', $is_uploaded['thumbnails_array']);

						// Count Photos
						$photos_number     = count($photos);

						// Update Ad
						Ad::where('ad_id', $ad_id)->update([
							'photos'        => $previews,
							'thumbnails'    => $thumbnails,
							'photos_number' => $photos_number,
						]);

					}else{

						// Error uploading photos
						return back()->with('error', 'Oops! Something went wrong while uploading photos.');

					}
				}elseif ($photos && $ad->photos == ''){
			
                    //Check if photos not empty
                    if(!empty($photos)):
                        // Upload Photos
                        $photos      = Input::file('photos');

                        // Get general settings
                        $general     = DB::table('settings_general')->where('id', 1)->first();

                        // Check where to upload photos
                        if ($general->default_host == 'local') {
                            
                            // Upload Files to Localhost
                            $is_uploaded = Uploader::upload($photos, $ad_id);
                            $images_host = 'local';

                        }elseif ($general->default_host == 'amazon') {
                            
                            // Upload Files to Amazon
                            $is_uploaded = EverestCloud::uploadToAmazon($photos, $ad_id);
                            $images_host = 'amazon';

                        }

                        // Check if Photos has been successfully uploaded
                        if ($is_uploaded) {

                            // Get Previews Photos
                            $previews          = implode('||', $is_uploaded['previews_array']);

                            // Get Thumbnails Photos
                            $thumbnails        = implode('||', $is_uploaded['thumbnails_array']);

                            // Count Photos
                            $photos_number     = count($photos);

                            // Update Ad
                            Ad::where('ad_id', $ad_id)->update([
                                'photos'        => $previews,
                                'thumbnails'    => $thumbnails,
                                'photos_number' => $photos_number,
                            ]);
                        }
                    endif;

                }

				// check if update ad status
				if (!$ad->status) {
					if ($status) {
						// Send notification
						DB::table('notifications_ads_accepted')->insert([
							'user_id'    => $ad->user_id, 
							'ad_id'      => $ad->ad_id, 
							'created_at' => Carbon::now(), 
						]);
					}
				}

				return back()->with('success', 'Congratulations! Ad has been successfully updated.');

			}

		}else{
			// Not found
			return redirect('dashboard/ads')->with('error', 'Oops! Ad not found.');
		}
	}

}