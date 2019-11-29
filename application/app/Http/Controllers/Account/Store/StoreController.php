<?php

namespace App\Http\Controllers\Account\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Store;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use Auth;
use Validator;
use Image;
use Protocol;
use Uploader;
use Helper;
use SEO;
use SEOMeta;
use Purifier;
use Theme;

/**
* StoreController class
*/
class StoreController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
     * Store Settings
     */
    public function settings()
    {
        // Get user id
        $user_id = Auth::id();

        // Check Store
        $store   = Store::where('owner_id', $user_id)->first();

        if ($store) {
            
            // Get geo settings
            $settings_geo = Helper::settings_geo();
            
            // Get user country
            $country = Country::where('sortname', $store->country)->first();

            if ($settings_geo->is_international) {
            
                // Get Countries
                $countries  = Country::get();

                // Check if states enabled
                if ($settings_geo->states_enabled) {
                    
                    // states
                    $states = State::where('country_id', $country->id)->get();
                    
                }else{
                    
                    // States not enabled
                    $states = null;

                }

                // Check if cities enabled
                if ($settings_geo->cities_enabled) {
                    
                    // Get cities
                    $cities = City::where('state_id', $store->state)->get();

                }else{

                    // Cities not enabled
                    $cities = null;

                }
                

            }else{

                // Get countries
                $countries = Country::where('id', $settings_geo->default_country)->get();

                // Check if states enabled
                if ($settings_geo->states_enabled) {
                    
                    // Get states 
                    $states = State::where('country_id', $settings_geo->default_country)->get();

                }else{

                    // States not enabled
                    $states = null;

                }

                // Check if cities enabled
                if ($settings_geo->cities_enabled) {
                    
                    // Get cities
                    $cities = City::where('state_id', $settings_geo->default_state)->get();

                }else{

                    // cities not enabled
                    $cities = null;

                }

            }
            

            // send data
            $data = array(
                'store'     => $store, 
                'countries' => $countries, 
                'states'    => $states, 
                'cities'    => $cities, 
            );

            // Get Tilte && Description
            $title      = Helper::settings_general()->title;
            $long_desc  = Helper::settings_seo()->description;
            $keywords   = Helper::settings_seo()->keywords;

            // Manage SEO
            SEO::setTitle(__('title.lang_store_settings').' | '.$title);
            SEO::setDescription($long_desc);
            SEOMeta::addKeyword([$keywords]);

            return view($this->theme.'.account.store.settings')->with($data);

        }else{
            // Not found
            return redirect('/account/settings')->with('error', __('return/error.lang_you_dont_have_store'));
        }

    }

    /**
     * Update Store Settings
     */
    public function update(Request $request)
    {
        // Get user id
        $user_id = Auth::id();
        
        // Check Store
        $store   = Store::where('owner_id', $user_id)->first();

        if ($store) {

            // Check geo settings
            $settings_geo = Helper::settings_geo();

            if ($settings_geo->is_international) {
                
                // Country rule
                $country_rule = 'required|exists:countries,sortname';

            }else{

                // Country rule
                $country_rule = '';

            }

            // Make Rules
            $rules = array(
                'username'   => [
                    'required',
                    'min:3',
                    Rule::unique('stores')->ignore($store->id)
                    ], 
                'title'      => [
                    'required',
                    'min:3',
                    Rule::unique('stores')->ignore($store->id)
                    ],  
                'short_desc' => 'required', 
                'long_desc'  => 'required', 
                'category'   => 'required|numeric|exists:categories,id', 
                'country'    => $country_rule, 
                'state'      => 'numeric|exists:states,id', 
                'city'       => 'numeric|exists:cities,id', 
                'fb_page'    => 'active_url', 
                'tw_page'    => 'active_url', 
                'go_page'    => 'active_url', 
                'yt_page'    => 'active_url', 
                'website'    => 'active_url', 
                'logo'       => 'image|mimes:jpg,jpeg,png|max:500', 
                'cover'      => 'image|mimes:jpg,jpeg,png|max:1500', 
            );

            // Make Validation
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // error
                return back()->withErrors($validator);
            }else{

                // Get Inputs
                $username   = $request->get('username');
                $title      = $request->get('title');
                $short_desc = $request->get('short_desc');
                $long_desc  = Purifier::clean($request->get('long_desc'));
                $category   = $request->get('category');
                $country    = $request->get('country');
                $state      = $request->get('state');
                $city       = $request->get('city');
                $fb_page    = $request->get('fb_page');
                $tw_page    = $request->get('tw_page');
                $go_page    = $request->get('go_page');
                $yt_page    = $request->get('yt_page');
                $website    = $request->get('website');
                $tawk       = $request->get('tawk');
                $address    = $request->get('address');
                $logo       = $request->file('logo');
                $cover      = $request->file('cover');

                // Update Store
                Store::where('owner_id', $user_id)->update([
                    'username'   => $username,
                    'title'      => $title,
                    'category'   => $category,
                    'short_desc' => $short_desc,
                    'long_desc'  => $long_desc,
                    'address'    => $address,
                    'fb_page'    => $fb_page,
                    'tw_page'    => $tw_page,
                    'go_page'    => $go_page,
                    'yt_page'    => $yt_page,
                    'website'    => $website,
                    'tawk'       => $tawk,
                ]);

                // Check if request country
                if ($country) {

                    Store::where('owner_id', $user_id)->update([
                        'country' => $country
                    ]); 

                }

                // Check if request state
                if ($state) {

                    Store::where('owner_id', $user_id)->update([
                        'state' => $state
                    ]); 

                }

                // Check if request city
                if ($city) {

                    Store::where('owner_id', $user_id)->update([
                        'city' => $city
                    ]); 

                }

                // Upload new store logo
                if ($logo) {
                    
                    // Get Store folder
                    $store_path = public_path().'/uploads/stores/'.$username;

                    // Check if Store Folder exists
                    if (!is_dir($store_path)) {
                        $store_path = mkdir(public_path().'/uploads/stores/'.$username, 0777);
                    }else{
                        // Delete old files
                        Uploader::deleteFolderFiles($store_path);
                    }

                    // Make new name
                    $logo_name = $username.'.png';
                    
                    // Upload Logo
                    $logo_img  = Image::make($logo->getRealPath());
                    
                    // Resize Logo
                    $logo_img->resize(200, 200);
                    
                    // Save Logo
                    $logo_img->save($store_path.'/'.$logo_name);
                    
                    // Logo link
                    $logo_url = Protocol::home().'/application/public/uploads/stores/'.$username.'/'.$logo_name;

                    Store::where('owner_id', $user_id)->update([
                        'logo' => $logo_url
                    ]);

                }

                // Upload new store cover
                if ($cover) {
                    
                    // Make new name
                    $cover_name  = md5(time().uniqid().rand()).'.png';
                    
                    // Get Covers folder
                    $covers_path = public_path('/uploads/covers');
                    
                    // Upload Cover
                    $cover_img   = Image::make($cover->getRealPath());
                    
                    // Save Cover
                    $cover_img->save($covers_path.'/'.$cover_name);
                    
                    // Cover link
                    $cover       = Protocol::home().'/application/public/uploads/covers/'.$cover_name;

                    Store::where('owner_id', $user_id)->update([
                        'cover' => $cover
                    ]);

                }

                // Success
                return redirect('/account/store/settings')->with('success', __('return/success.lang_store_updated'));

            }

        }else{
            // Not found
            return redirect('/')->with('error', __('return/error.lang_you_dont_have_store'));
        }

    }

}