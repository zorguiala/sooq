<?php



namespace App\Http\Controllers\Account;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Auth;

use App\User;

use App\Models\Country;

use App\Models\State;

use App\Models\City;

use DB;

use Hash;

use Image;

use Protocol;

use Carbon\Carbon;

use Validator;

use SEO;

use SEOMeta;

use Helper;

use Theme;

use Propaganistas\LaravelPhone\PhoneNumber;



/**

* AccountSettings class

*/

class AccountSettings extends Controller

{

    public $theme = '';

	

	function __construct()

	{

		$this->middleware('auth');

        $this->theme = Theme::get();

	}



	/**

	 * Account Settings

	 */

	public function settings()

	{

		// Get user id

		$user_id      = Auth::id();

		

		// Get User Info

		$user         = User::where('id', $user_id)->first();

		

		// Get GEO Settings

		$settings_geo = Helper::settings_geo();



		// Get user country

		$country = Country::where('sortname', $user->country_code)->first();



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

				$cities = City::where('state_id', $user->state)->get();



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

		

		// Send data

		$data      = array(

			'user'      => $user, 

			'countries' => $countries, 

			'states'    => $states, 

			'cities'    => $cities, 

		);



		// Get Tilte && Description

        $title      = Helper::settings_general()->title;

        $long_desc  = Helper::settings_seo()->description;

        $keywords   = Helper::settings_seo()->keywords;



        // Manage SEO

        SEO::setTitle(__('title.lang_account_settings').' | '.$title);

        SEO::setDescription($long_desc);

        SEO::opengraph()->setUrl(Protocol::home());

        SEOMeta::addKeyword([$keywords]);



		return view($this->theme.'.account.settings')->with($data);

	}



	/**

	 * Update Account Settings

	 */

	public function update(Request $request)

	{

		// Get user id

		$user_id      = Auth::id();

		

		// Get user info

		$user         = User::where('id', $user_id)->first();

		

		// Get GEO Settings

		$settings_geo = Helper::settings_geo();

		

		// Make Rules

		$rules   = array(

			'first_name'   => 'required|max:200', 

			'last_name'    => 'required|max:200', 

			'username'     => [

				'required',

				'min:3',

				'max:200',

				Rule::unique('users')->ignore($user_id)

			],

			'email'        => [

				'required', 

				'email',

				'max:200',

				Rule::unique('users')->ignore($user_id)

			], 

			'phone'        => 'required|numeric',

			'gender'       => 'required|boolean', 

			'country'      => 'nullable|exists:countries,sortname', 

			'state'        => 'numeric|exists:states,id', 

			'city'         => 'numeric|exists:cities,id', 

			'phonecode'    => 'required|numeric|exists:countries,phonecode', 

			'phone_hidden' => 'required|boolean', 

			'avatar'       => 'image|mimes:png,jpg,jpeg|max:2000', 

			'old_password' => 'required_with:new_password|min:6|max:200', 

			'new_password' => 'required_with:old_password|min:6|max:200', 

		);



		// Make Validation

		$validator = Validator::make($request->all(), $rules);



		if ($validator->fails()) {



			// Error

			return redirect('/account/settings')->withErrors($validator);



		}else{



			// Get inputs values

			$first_name        = $request->get('first_name');

			$last_name         = $request->get('last_name');

			$username          = $request->get('username');

			$email             = $request->get('email');

			$phone             = $request->get('phone');

			$phonecode         = $request->get('phonecode');

			$gender            = $request->get('gender');

			$country           = $request->get('country');

			$state             = $request->get('state');

			$city              = $request->get('city');

			$phone_hidden      = $request->get('phone_hidden');

			$avatar            = $request->file('avatar');

			$old_password      = $request->get('old_password');

			$new_password      = $request->get('new_password');

			$full_phone_format = '+'.$phonecode.$phone;

			

			// Check if site is international

			if ($settings_geo->is_international) {



				// Get country

				$getCountry  = Country::where('sortname', $country)->first();

				

				// Check if state exists in the selected country

				$check_state = State::where('country_id', $getCountry->id)->first();



				if ($check_state) {

					

					// Check if city exists

					$check_city = city::where('state_id', $check_state->id)->first();



					if (!$check_city) {

						

						// City not available in this country

						return redirect('/account/settings')->with('error', 'Oops! City not exists in this country.');



					}



				}else{



					// state not available in this country

					return redirect('/account/settings')->with('error', 'Oops! State not exists in this country.');



				}



				// Update Country, state and city

				User::where('id', $user_id)->update([

					'country_code' => $country,

					'state'        => $state,

					'city'         => $city,

				]);



			}else{



				// Get default country

				$getCountry = Country::where('id', $settings_geo->default_country)->first();



				// Check if state exists in the selected country

				$check_state = State::where('country_id', $getCountry->id)->first();



				if ($check_state) {

					

					// Check if city exists

					$check_city = city::where('state_id', $check_state->id)->first();



					if (!$check_city) {

						

						// City not available in this country

						return redirect('/account/settings')->with('error', 'Oops! City not exists in this country.');



					}



				}else{



					// state not available in this country

					return redirect('/account/settings')->with('error', 'Oops! State not exists in this country.');



				}



				// Update Country, state and city

				User::where('id', $user_id)->update([

					'country_code' => 'SA',

					'state'        => $state,

					'city'         => $city,

				]);



			}



			// Want new password?

			if ($new_password) {

				

				// Check password

				if (Hash::check($old_password, $user->password)) {

					// Update password

					User::where('id', $user_id)->update([

						'password' => Hash::make($new_password)

					]);

				}else{

					// Not matched

					return redirect('/account/settings')->with('error', __('return/error.lang_old_password_incorrect'));

				}



			}



			// Check if request new avatar

			if ($avatar) {



				$avatar_name = $username.'-'.md5(time()).'.png';

				

				// Upload Avatar

				$avatar_img  = Image::make($avatar->getRealPath());

				

				// Resize Avatar

				$avatar_img->resize(100, 100);

				

				// Save Avatar

				$avatar_img->save(public_path().'/uploads/avatars/'.$avatar_name);

				

				// Create avatar url

				$avatar_url  = Protocol::home().'/application/public/uploads/avatars/'.$avatar_name;



				// Update

				User::where('id', $user_id)->update([

					'avatar' => $avatar_url

				]);



			}



			// Update User

			User::where('id', $user_id)->update([

				'first_name'   => $first_name,

				'last_name'    => $last_name,

				'username'     => $username,

				'email'        => $email,

				'phone'        => $phone,

				'phonecode'    => $phonecode,

				'gender'       => $gender,

				'phone_hidden' => $phone_hidden

			]);	



			// Success

			return redirect('/account/settings')->with('success', __('return/success.lang_profile_updated'));



		}

	}

}