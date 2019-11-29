<?php
namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Mail\AlertMatchFound;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Notifications\Admin\AdPending;
use Validator;
use DB;
use Input;
use Image;
use Redirect;
use Uploader;
use EverestCloud;
use Random;
use Carbon\Carbon;
use App\User;
use App\Models\Ad;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Protocol;
use Profile;
use SEO;
use SEOMeta;
use Helper;
use File;
use Countries;
use Theme;
use Toolkito\Larasap\SendTo;

/**
* CreateController
*/
class CreateController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Create New Ad
	 */
	public function create()
	{

		// Check if not admin, and check warnings
		if (!Auth::user()->is_admin) {

			$settings_auth = Helper::settings_auth();

			// Check if user has too many warnings
			$warnings = DB::table('notifications_warnings')->where('user_id', Auth::id())->count();

			if ($warnings >= $settings_auth->max_warnings) {
				
				return redirect('/')->with('error', __('return/error.lang_too_many_warnings'));

			}

		}

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
		);

		// Get Tilte && Description
		$title      = Helper::settings_general()->title;
		$long_desc  = Helper::settings_seo()->description;
		$keywords   = Helper::settings_seo()->keywords;

		// Manage SEO
		SEO::setTitle(__('title.lang_create_ad').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home().'/create');
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.ads.create')->with($data);

	}

	/**
	 * Insert New Ad
	 */
	public function insert(Request $request)
	{

		if (!Auth::user()->is_admin) {

			// Get membership settings
			$settings_membership = Helper::settings_membership();

			// check ads per day by user
			$this_day_ads        = Ad::where('user_id', Auth::id())->where('created_at', '>=', Carbon::now()->subDay())->count();

			// if user not admin or moderator
			if (Profile::hasStore(Auth::id()) && !Auth::user()->is_admin) {

				if ($this_day_ads >= $settings_membership->pro_ads_per_day) {
					// try again tomorrow
					return redirect('create')->with('error', __('return/error.lang_you_can_add_up_to_x_ads_per_day', ['ads' => $settings_membership->pro_ads_per_day]));
				}

			}else{

				if ($this_day_ads >= $settings_membership->free_ads_per_day) {
					// try again tomorrow
					return redirect('create')->with('error', __('return/error.lang_you_can_add_up_to_x_ads_per_day', ['ads' => $settings_membership->free_ads_per_day]));
				}

			}

			$settings_auth = Helper::settings_auth();

			// Check if user has too many warnings
			$warnings = DB::table('notifications_warnings')->where('user_id', Auth::id())->count();

			if ($warnings >= $settings_auth->max_warnings) {
				
				return redirect('/')->with('error', __('return/error.lang_too_many_warnings'));

			}
		
		}

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
			'title'                => 'required|max:100',
			'description'          => 'required', 
			'category'             => 'required|numeric|exists:categories,id', 
			'country'              => 'required|exists:countries,sortname', 
			'state'                => $state_rule, 
			'city'                 => $city_rule, 
			'price'                => 'required', 
			'currency'             => 'required|exists:currencies,code', 
			'negotiable'           => 'required|boolean', 
			'terms'                => 'required', 
			'condition'            => 'required|boolean', 

			'affiliate_link'       => 'active_url'
		);

		// Make rules on inputs
		$validator = Validator::make($request->all(), $rules);

		// Check if validation fails
		if ($validator->fails()) {
			
			// Error
			return Redirect::to('create')->withErrors($validator)
										 ->withInput();

		}else{

			// Get Inputs Values
			$title       = $request->get('title');
			$description = $request->get('description');
			$category    = $request->get('category');
			$country     = $request->get('country');
			$state       = $request->get('state');
			$city        = $request->get('city');
			$price       = $request->get('price');
			$currency    = $request->get('currency');
			$is_used     = $request->get('condition');
			$negotiable  = $request->get('negotiable');
			$latitude    = $request->get('latitude');
			$longitude   = $request->get('longitude');
			$radius      = $request->get('radius');

			// Check if user has store
			if (Profile::hasStore(Auth::id())) {

				// Has Store
				$youtube        = $request->get('youtube') ? : NULL ;
				$affiliate_link = $request->get('affiliate_link') ? : NULL;
				$regular_price  = $request->get('regular_price') ? : NULL;

				// Check Regular Price
				if ($regular_price && !Helper::isCurrency($regular_price)) {
					return redirect('create')->with('error', __('return/error.lang_price_format_invalid'))->withInput();
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

			}

			// Check Price
			if (!Helper::isCurrency($price)) {
				return redirect('create')->with('error', __('return/error.lang_price_format_invalid'))->withInput();
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

			// Create New Ad ID
			$ad_id       = Random::unique();

			// Generate AD Slug
			$slug        = Random::slug($title, $ad_id);
			
			// Get User ID
			$user_id     = Auth::id();
			
			// Create Ad Dates
			$created_at  = Carbon::now();
			$updated_at  = Carbon::now();
			$ends_at     = Helper::ad_ends_at();
			
            // Check Ad Status
            $status            = Helper::status(true, false);
            
            // Check if Ad Featured
            if (Auth::user()->is_admin || Profile::hasStore(Auth::id())) {
                $is_featured = 1;
            }else{
                $is_featured = 0;
            }
            
            // Insert Ad
            $ad                 = new Ad;
            $ad->ad_id          = $ad_id;
            $ad->affiliate_link = $affiliate_link;
            $ad->slug           = $slug;
            $ad->user_id        = $user_id;
            $ad->price          = Helper::isCurrency($price);
            $ad->regular_price  = $regular_price;
            $ad->currency       = $currency;
            $ad->category       = $category;

            // Upload Photos
            $photos      = Input::file('photos');

            //Check if photos not empty
            if(!empty($photos)):

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

                    $ad->photos         = $previews;
                    $ad->thumbnails     = $thumbnails;
                    $ad->photos_number  = $photos_number;
                    $ad->images_host    = $images_host;
                }else{

                    return redirect('create')->with('error', __('return/error.lang_error_uploading_images'))->withInput();

                }
            endif;
            
            $ad->youtube        = $youtube;
            $ad->negotiable     = $negotiable;
            $ad->title          = $title;
            $ad->description    = $description;
            $ad->is_used        = $is_used;
            $ad->country        = $country;
            $ad->state          = $state;
            $ad->city           = $city;
            $ad->radius         = $radius;
            $ad->latitude       = $latitude;
            $ad->longitude      = $longitude;
            $ad->status         = $status;
            $ad->is_featured    = $is_featured;
            $ad->ends_at        = $ends_at;
            $ad->save();

            // Check for alerts
            $alerts = DB::table('search_alert')->where('keyword', 'LIKE', '%'. $title .'%')->orWhere('keyword', 'LIKE', '%'. $description .'%')->get();

            if (count($alerts)) {
                
                // send a notification to all emails 
                foreach ($alerts as $alert) {

                    // Send Email
                    Mail::to($alert->email)->send(new AlertMatchFound($ad_id, $title));
                    
                }

            }

            // Check if ad need admin approval
            if (!$status) {
                
                // Send notification to admins via dashboard
                DB::table('notifications_ads')->insert([
                    'user_id'    => $user_id,
                    'ad_id'      => $ad_id,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);

                $users = User::where('is_admin', 1)->get();

                foreach ($users as $user) {
                    // Send notification to admins via email
                    $user->notify(new AdPending());
                }

                return Redirect::to('/create')->with('success', __('return/success.lang_ad_under_review'));

            }

            // Check if user setting autoshare system
            $autoshare = DB::table('auto_share')->where('user_id', $user_id)->first();

            if ($autoshare) {
                
                // AutoShare via Twitter
                if ($autoshare->tw_active) {
                    
                    try {
                        
                        /**
                         * Generate Message Text to send to Twitter
                         * @var string
                         */
                        $textMessage  = $title;
                        $textMessage .= "\n";
                        $textMessage .= Protocol::home().'/vi/'.$ad_id;

                        /**
                         * Generate Ad Image
                         * @var String
                         */
                        $textPicture = public_path('uploads/images/'.$ad_id.'/previews/preview_0.jpg');
                        
                        // Send request to Twitter
                        SendTo::Twitter($textMessage, [$textPicture]);

                    } catch (\Exception $e) {
                        
                        \Log::error($e->getMessage());
                        
                    }

                }

                // AutoShare via Facebook
                if ($autoshare->fb_active) {
                    
                    try {

                        // Send request to Facebook
                        SendTo::Facebook(
                            'link',
                            [
                                'link'    => Protocol::home().'/vi'.$ad_id,
                                'message' => $title
                            ]
                        );

                    } catch (\Exception $e) {
                        
                        \Log::error($e->getMessage());

                    }

                }

                // AutoShare via Telegram
                if ($autoshare->tg_active) {
                    
                    try {
                        
                        /**
                         * Generate Telegram message text
                         * @var string
                         */
                        $textMessage = $title . "\n" .Protocol::home().'/vi'.$ad_id;
                        $textPicture = Helper::ad_first_image($ad_id, $images_host);
                    
                        // Send request to Telegram
                        SendTo::Telegram(
                            $textMessage,
                            [
                                'type' => 'photo', 
                                'file' => $textPicture
                            ]
                        );

                    } catch (\Exception $e) {
                        
                        \Log::error($e->getMessage());

                    }

                }

            }

            // Ad Post with success, Show Ad
            return Redirect::to(Protocol::home().'/listing/'.$slug);

		}	
			
	}
}