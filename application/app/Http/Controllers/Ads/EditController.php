<?php



namespace App\Http\Controllers\Ads;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Auth;

use DB;

use App\Models\Ad;

use App\Models\Country;

use App\Models\State;

use App\Models\City;

use Input;

use App\User;

use Uploader;

use SEO;

use SEOMeta;

use Helper;

use Protocol;

use Validator;

use Redirect;

use Carbon\Carbon;

use Random;

use Theme;

use Profile;



/**

* EditController

*/

class EditController extends Controller

{

    public $theme = '';

	

	function __construct()

	{

		$this->middleware('auth');

        $this->theme = Theme::get();

	}



	/**

	 * Edit Ad

	 */

	public function edit(Request $request, $ad_id)

	{

		// Get user id

		$user_id = Auth::id();



		// Check ad id

		$ad = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('status', 1)->where('is_trashed', 0)->first();



		if ($ad) {

			

			// Get user

			$user          = User::where('id', Auth::id())->first();

			

			// Get GEO Settings

			$settings_geo  = Helper::settings_geo();



			// Check if this site config for a international

			if ($settings_geo->is_international) {



				// Get country

				$country   = Country::where('sortname', $user->country_code)->first();

				

				$countries = Country::all();

				$states    = State::where('country_id', $country->id)->get();

				$cities    = City::where('state_id', $user->state)->get();



			}else{



				// Get States

				$countries = Country::where('id', $settings_geo->default_country)->get();

				$states    = State::where('country_id', $settings_geo->default_country)->get();

				$cities    = City::where('state_id', $settings_geo->default_state)->get();



			}



			// Send data

			$data = array(

				'countries' => $countries, 

				'states'    => $states, 

				'cities'    => $cities, 

				'user'      => $user, 

				'ad'        => $ad, 

			);



			// Get Tilte && Description

			$title      = Helper::settings_general()->title;

			$short_desc = Helper::settings_general()->description;

			$long_desc  = Helper::settings_seo()->description;

			$keywords   = Helper::settings_seo()->keywords;



			// Manage SEO

			SEO::setTitle(__('title.lang_edit_ad').' | '.$title);

	        SEO::setDescription($long_desc);

	        SEO::opengraph()->setUrl(Protocol::home().'/account/ads/edit/'.$ad_id);

	        SEOMeta::addKeyword([$keywords]);



			// Ad found

			return view($this->theme.'.account.ads.edit')->with($data);



		}else{

			// Not found

			return redirect('account/ads')->with('error', __('return/error.lang_ad_not_found'));

		}

	}



	/**

	 * Update Ad

	 */

	public function update(Request $request, $ad_id)

	{

		// Get user id

		$user_id = Auth::id();



		// Check ad id

		$ad = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->first();



		if ($ad) {



			// Get GEO Settings

			$settings_geo = Helper::settings_geo();



			// Check if states enabled

			if ($settings_geo->states_enabled) {



				$state_rule = 'required|exists:states,id';



			}else{



				$state_rule = '';



			}



			// Check if cities enabled

			if ($settings_geo->cities_enabled) {

				

				$city_rule  = 'required|exists:cities,id';



			}else{



				$city_rule  = '';



			}

			

			// Make Rules

			$rules = array(

				'title'          => 'required|max:100', 

				'description'    => 'required', 

				'category'       => 'required|numeric|exists:categories,id',  

				'country'        => 'required|exists:countries,sortname', 

				'state'          => $state_rule, 

				'city'           => $city_rule, 

				'negotiable'     => 'required|boolean',

				'condition'      => 'required|boolean',

				'oos'            => 'boolean',

				'currency'       => 'required|exists:currencies,code', 

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

				$currency    = $request->get('currency');

				$photos      = $request->file('photos');

				$country     = $request->get('country');

				$state       = $request->get('state');

				$city        = $request->get('city');

				$latitude    = $request->get('latitude');

				$longitude   = $request->get('longitude');

				$radius      = $request->get('radius');



				// Generate AD Slug

				$slug        = Random::slug($title, $ad_id);



				// Check Price

				if (!Helper::isCurrency($price)) {

					// Error price

					return back()->with('error', __('return/error.lang_price_format_invalid'));

				}



				// Check if area radius is number

				if (!is_numeric($radius)) {

					$radius = 300;

				}



				// Validate Latitude and longitude

				if (!Helper::isValidLongitude($longitude) && !Helper::isValidLatitude($latitude)) {

					

					// Not valid

					$latitude  = null;

					$longitude = null;



				}



				// Check if user has store

				if ( auth()->user()->account_type == true ) {



					// Has Store

					$youtube        = $request->get('youtube') ? : NULL ;

					$affiliate_link = $request->get('affiliate_link') ? : NULL;

					$regular_price  = $request->get('regular_price') ? : NULL;

					$is_oos         = $request->get('oos') ? : FALSE;



					// Check Regular Price

					if ($regular_price && !Helper::isCurrency($regular_price)) {

						return back()->with('error', __('return/error.lang_price_format_invalid'))->withInput();

					}



					// Check youtube

					if ($youtube && (!Protocol::isValidYoutubeURL($youtube))) {

						return redirect('create')->with('error', __('update.lang_invalid_youtube_url'))->withInput();

					}



				}else{



					// Has no store

					$youtube        = NULL;

					$regular_price  = NULL;

					$affiliate_link = NULL;

					$is_oos         = FALSE;



				}



				// Check Ad Status

				$status            = Helper::status(true, false);



				// Update Ad

				Ad::where('ad_id', $ad_id)->update([

					'title'          => $title, 

					'affiliate_link' => $affiliate_link,

					'slug'           => $slug, 

					'description'    => $description, 

					'country'        => $country, 

					'city'           => $city, 

					'state'          => $state, 

					'radius'         => $radius,

					'latitude'       => $latitude,

					'longitude'      => $longitude,

					'price'          => Helper::isCurrency($price), 

					'regular_price'  => $regular_price, 

					'category'       => $category, 

					'negotiable'     => $negotiable, 

					'currency'       => $currency, 

					'status'         => $status, 

					'youtube'        => $youtube, 

					'is_used'        => $condition, 

					'is_oos'         => $is_oos,

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



				return back()->with('success', __('return/success.lang_ad_updated'));



			}



		}else{

			// Not found

			return redirect('account/ads')->with('error', __('return/error.lang_ad_not_found'));

		}

	}



}