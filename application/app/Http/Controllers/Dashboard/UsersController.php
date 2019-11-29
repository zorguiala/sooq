<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Auth;
use App\User;
use App\Models\Ad;
use App\Models\Store;
use App\Notifications\AdminLevel;
use Uploader;
use Hash;
use DB;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

/**
* UsersController
*/
class UsersController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Users
	 */
	public function users()
	{
		$users = User::orderBy('id', 'desc')->paginate(30);

        return view('dashboard.users.users')->with('users', $users);
	}

	/**
	 * Delete User
	 */
	public function delete(Request $request, $username)
	{
		// Check user
		$user = User::where('username', $username)->where('id', '!=', 1)->first();

		if ($user) {
			
			// Delete User 
			DB::table('comments')->where('user_id', $user->id)->delete();
			DB::table('activations')->where('email', $user->email)->delete();
			DB::table('reviews')->where('user_id', $user->id)->delete();
			DB::table('auto_share')->where('user_id', $user->id)->delete();
			DB::table('favorites')->where('owner', $user->id)->delete();
			DB::table('notifications_ads')->where('user_id', $user->id)->delete();
			DB::table('notifications_ads_accepted')->where('user_id', $user->id)->delete();
			DB::table('offers')->where('offer_to', $user->id)->delete();
			DB::table('stats')->where('owner', $user->id)->delete();
			DB::table('stores')->where('owner_id', $user->id)->delete();
			DB::table('users_mailbox')->where('msg_to', $user->username)->delete();
			Ad::where('user_id', $user->id)->delete();
			User::where('id', $user->id)->delete();

			// Success
			return redirect('/dashboard/users')->with('success', 'User has been successfully deleted.');

		}else{
			// Not found
			return back()->with('error', 'Oops! User not found.');
		}
	}

	/**
	 * Edit User
	 */
	public function edit(Request $request, $username)
	{
		// Check user
		$user = User::where('username', $username)->first();

		if ($user) {

			// Get user id
			$user_id = Auth::id();

			// you cannot change admin id = 1
			if (($user_id != 1) && ($user->id == 1)) {
				return redirect('/dashboard/users')->with('error', 'Oops! You cannot edit this user.');
			}

			// Get Countries, States, Cities
			$countries       = Country::get();
			$default_country = Country::where('sortname', $user->country_code)->first();
			$states          = State::where('country_id', $default_country->id)->get();
			$city            = City::where('id', $user->city)->first();
			if ($city) {
				$cities          = City::where('state_id', $city->state_id)->get();
			}else{
				$cities          = City::where('country_id', $default_country->id)->get();
			}
			

			// Send data
			$data = array(
				'user'            => $user, 
				'countries'       => $countries, 
				'default_country' => $default_country, 
				'states'          => $states, 
				'cities'          => $cities, 
			);

			return view('dashboard.users.edit')->with($data);

		}else{
			// Not found
			return redirect('/dashboard/users')->with('error', 'Oops! User not found.');
		}

	}

	/**
	 * Update User
	 */
	public function update(Request $request, $username)
	{
		// Check user
		$user = User::where('username', $username)->first();

		if ($user) {

			// Get user id
			$user_id = Auth::id();
			
			// you cannot change admin id = 1
			if (($user_id != 1) && ($user->id == 1)) {
				return redirect('/dashboard/users')->with('error', 'Oops! You cannot edit this user.');
			}

			// Make Rules
			$rules = array(
				'first_name'   => 'required', 
				'last_name'    => 'required', 
				'username'     => [
					'required',
					'min:3',
					Rule::unique('users')->ignore($user->id)
				],
				'email'        => [
					'required', 
					'email',
					Rule::unique('users')->ignore($user->id)
				], 
            	'phone'        => [
            		'numeric',
					Rule::unique('users')->ignore($user->id)
            	],
				'phonecode'    => 'numeric|exists:countries,phonecode', 
				'phone_hidden' => 'required|boolean', 
				'gender'       => 'required|boolean',
				'is_admin'     => 'required|boolean', 
				'account_type' => 'required|boolean', 
				'status'       => 'required|boolean', 
				'avatar'       => 'image|mimes:jpg,jpeg,png|max:1000', 
				'password'     => 'min:6|confirmed', 
			);

			// run validation
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				// Error
				return back()->withErrors($validator);
			}else{

				// Get Inputs values
				$first_name   =  $request->get('first_name');
				$last_name    =  $request->get('last_name');
				$new_username =  $request->get('username');
				$email        =  $request->get('email');
				$phone        =  $request->get('phone');
				$phonecode    =  $request->get('phonecode');
				$phone_hidden =  $request->get('phone_hidden');
				$gender       =  $request->get('gender');
				$is_admin     =  $request->get('is_admin');
				$account_type =  $request->get('account_type');
				$status       =  $request->get('status');
				$avatar       =  $request->file('avatar');
				$password     =  $request->get('password');

				// Admin user with id == 1 cannot change
				if (($user->id == 1) OR $is_admin) {
					$is_admin      = 1;
					$account_type  = 1;
					$status        = 1;
					$has_store     = 1;
					//$store_ends_at = Carbon::now()->addYears(10);
				}

				// Check if user account type is professional
				if ($account_type == 1) {
					$status       = 1;
				}

				// Update User
				User::where('username', $username)->update([
					'first_name'   => $first_name,
					'last_name'    => $last_name,
					'username'     => $new_username,
					'email'        => $email,
					'phone'        => $phone,
					'phonecode'    => $phonecode,
					'phone_hidden' => $phone_hidden,
					'gender'       => $gender,
					'is_admin'     => $is_admin,
					'account_type' => $account_type,
					'status'       => $status
				]);

				// Check if wants to edit avatar
				if ($avatar) {

					$avatar_link = Uploader::upload_avatar($avatar, $new_username);

					// Update Avatar
					User::where('username', $username)->update([
						'avatar' => $avatar_link
					]);

				}

				// check if want to edit password
				if ($password) {
										
					// Only admin with id == 1 can do this
					if (Auth::id() == 1) {
						
						// Update password
						User::where('username', $username)->update([
							'password' => Hash::make($password)
						]);

					}else{
						// You don't have permissions to do this
						return back()->with('error', 'Oops! You don\'t have permissions to change users passwords.');
					}

				}

				// If user level changed send notification
				if (!$user->is_admin) {
					if ($is_admin) {
						// Send notification
						$user->notify(new AdminLevel());
					}
				}

				// Success
				return redirect('dashboard/users/edit/'.$new_username)->with('success', 'Congratulations! User profile has been successfully updated.');


			}

		}else{
			// Not found
			return redirect('dashboard/users')->with('error', 'Oops! User not found.');
		}

	}

	/**
	 * Active User
	 */
	public function active(Request $request, $username)
	{
		// Check user
		$user = User::where('username', $username)->where('id', '!=', 1)->first();

		if ($user) {
			
			// Check if user already active
			if ($user->status == 1) {
				// Already active
				return redirect('dashboard/users')->with('error', 'Oops! User already active.');
			}else{

				// Update user
				User::where('username', $username)->update([
					'status' => 1
				]);

				return redirect('dashboard/users')->with('success', 'User has been successfully updated.');

			}

		}else{
			// Not found
			return redirect('dashboard/users')->with('error', 'Oops! User not found.');
		}
	}

	/**
	 * Inctive User
	 */
	public function inactive(Request $request, $username)
	{
		// Check user
		$user = User::where('username', $username)->where('id', '!=', 1)->first();

		if ($user) {
			
			// Check if user already active
			if ($user->status == 0) {
				// Already active
				return redirect('dashboard/users')->with('error', 'Oops! User already inactive.');
			}else{

				// Cannot inactive admin user
				if ($user->id == 1) {
					return redirect('dashboard/users')->with('error', 'Oops! You cannot inactive this user.');
				}

				// Update user
				User::where('username', $username)->update([
					'status' => 0
				]);

				return redirect('dashboard/users')->with('success', 'User has been successfully updated.');

			}

		}else{
			// Not found
			return redirect('dashboard/users')->with('error', 'Oops! User not found.');
		}
	}

	/**
	 * User Details
	 */
	public function details(Request $request, $username)
	{
		// Check user
		$user = User::where('username', $username)->first();

		if ($user) {
			
			// Get Ads stats
			$ads_today = Ad::where('user_id', $user->id)->whereDay('created_at', date('d'))->count();
			
			$ads_month = Ad::where('user_id', $user->id)->whereMonth('created_at', date('m'))->count();
			
			$ads_year  = Ad::where('user_id', $user->id)->whereYear('created_at', date('Y'))->count();

			// send data
			$data = array(
				'user'      => $user, 
				'ads_today' => $ads_today, 
				'ads_month' => $ads_month, 
				'ads_year'  => $ads_year, 
			);

			return view('dashboard.users.details')->with($data);

		}else{
			// Not found
			return redirect('dashboard/users')->with('error', 'Oops! User not found.');
		}
	}

	/**
	 * Get user ads
	 */
	public function ads(Request $request, $username)
	{
		// Check user
		$user = User::where('username', $username)->first();

		if ($user) {
			
			// Get user ads
			$ads = Ad::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(30);

			return view('dashboard.users.ads')->with('ads', $ads);

		}else{
			// Not found
			return redirect('/dashboard/users')->with('error', 'Oops! User not found.');
		}
	}

	/**
	 * Get user comments
	 */
	public function comments(Request $request, $username)
	{
		// Check user
		$user = User::where('username', $username)->first();

		if ($user) {
			
			// Get user comments
			$comments = DB::table('comments')->where('user_id', $user->id)->orderBy('id', 'desc')->paginate(30);

			return view('dashboard.users.comments')->with('comments', $comments);

		}else{
			// Not found
			return redirect('/dashboard/users')->with('error', 'Oops! User not found.');
		}
	}

	/**
	 * Send Warning
	 */
	public function warning(Request $request, $username)
	{
		// Get user
		$user = User::where('username', $username)->where('id', '!=', 1)->first();

		if ($user) {
			
			// Send user new warning
			DB::table('notifications_warnings')->insert([
				'user_id'    => $user->id,
				'created_at' => Carbon::now(),
			]);

			// Success
			return redirect('/dashboard/users')->with('success', 'Warning has been successfully sent.');

		}else{
			// Not found
			return redirect('/dashboard/users')->with('error', 'Oops! User not found.');
		}
	}

	/**
	 * Delete All warnings
	 */
	public function delete_warnings(Request $request, $username)
	{
		// Get user
		$user = User::where('username', $username)->where('id', '!=', 1)->first();

		if ($user) {
			
			// delete all warnings
			DB::table('notifications_warnings')->where('user_id', $user->id)->delete();

			// Success
			return redirect('/dashboard/users')->with('success', 'Warnings has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/users')->with('error', 'Oops! User not found.');
		}
	}

	/**
	 * Make a store for a user
	 * @param  Request $request  [description]
	 * @param  [type]  $username [description]
	 * @return [type]            [description]
	 */
	public function makeStore(Request $request, $username)
	{
		
		// Get user
		$user = User::where('username', $username)
					->where('id', '!=', 1)
					->where('has_store', 0)
					->first();

		// Check if user exists
		if ($user) {

			// Make data to send
			$data = array(
				'user' => $user, 
			);

			return view('dashboard.users.create_store')->with($data);

		}else{

			// Not found
			return redirect('dashboard/users')->with('error', 'Oops! User not found or already has a store.');

		}

	}

	/**
	 * Insert new store
	 * @param  Request $request  [description]
	 * @param  [type]  $username [description]
	 * @return [type]            [description]
	 */
	public function insertStore(Request $request, $username)
	{
		
		// Get user
		$user = User::where('username', $username)
					->where('id', '!=', 1)
					->where('has_store', 0)
					->first();

		// Check if user exists
		if ($user) {

			// Make validation
			$request->validate([

				'username'   => 'required|unique:stores,username',
				'title'      => 'required',
				'short_desc' => 'required',
				'long_desc'  => 'required',
				'ends_at'    => 'required|integer|between:1,6000',
				'category'   => 'required|exists:categories,id',

			]);

			// Get inputs
			$username   = $request->get('username');
			$title      = $request->get('title');
			$short_desc = $request->get('short_desc');
			$long_desc  = $request->get('long_desc');
			$ends_at    = $request->get('ends_at');
			$category   = $request->get('category');
			$status     = 1;
			$country    = $user->country_code;
			$state      = $user->state ? $user->state : Helper::settings_geo()->default_state;
			$city       = $user->city ? $user->state : Helper::settings_geo()->default_city;

			// Create new store
			$store               = new Store;
			$store->owner_id     = $user->id;
			$store->username     = $username;
			$store->title        = $title;
			$store->short_desc   = $short_desc;
			$store->long_desc    = $long_desc;
			$store->category     = $category;
			$store->status       = $status;
			$store->country      = $country;
			$store->state        = $state;
			$store->city         = $city;
			$store->ends_at      = Carbon::now()->addDays($ends_at);
			$store->created_at   = Carbon::now();
			$store->updated_at   = Carbon::now();
			$store->save();

			// Get Uploads Folder
			$stores_folder = public_path().'/uploads/stores/';
			
			if (!is_dir($stores_folder.$username)) {
				
				// Create New Foler
				mkdir($stores_folder.$username, 0777);

			}

			// Update User
			$user->update([
				'account_type'  => 1,
				'has_store'     => 1,
				'store_ends_at' => Carbon::now()->addDays($ends_at)
			]);

			// Store has been created
			return redirect('dashboard/stores')->with('success', 'Congratulations! Store has been successfully created.');

		}else{

			// Not found
			return redirect('dashboard/users')->with('error', 'Oops! User not found or already has a store.');

		}

	}

}