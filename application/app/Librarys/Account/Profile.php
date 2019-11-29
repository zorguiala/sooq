<?php

namespace App\Library\Account;

use App\Models\Store;
use App\User;
use DB;
use Protocol;

/**
* Profile class
*/
class Profile
{
	
	/**
	 * Profile Picture
	 * @param integer $user_id
	 * @return string $url
	 */
	public static function picture($user_id)
	{
		$user = User::where('id', $user_id)->first();

		// Check user
		if ($user) {
			
			// Check if has store
			if (self::hasStore($user_id)) {
				return self::hasStore($user_id)->logo;
			}elseif ($user->avatar == 'avatar.png') {
				return Protocol::home().'/application/public/uploads/avatars/noavatar.png';
			}else{
				return $user->avatar;
			}

		}

		// User not found
		return Protocol::home().'/application/public/uploads/avatars/noavatar.png';
	}

	/**
	 * Profile Picture
	 * @param integer $user_id
	 * @return string $url
	 */
	public static function user_picture($user_id)
	{
		$user = User::where('id', $user_id)->first();

		// Check user
		if ($user) {
			
			if ($user->avatar == 'avatar.png') {
				return Protocol::home().'/application/public/uploads/avatars/noavatar.png';
			}else{
				return $user->avatar;
			}

		}

		// User not found
		return Protocol::home().'/application/public/uploads/avatars/noavatar.png';
	}

	/**
	 * Get Gender
	 * @param integer $type
	 * @return string $gender
	 */
	public static function gender($type)
	{
		if ($type == 1) {
			return \Lang::get('account/settings.lang_gender_male');
		}else{
			return \Lang::get('account/settings.lang_gender_female');
		}
	}

	/**
	 * Get User Full Name
	 * @param integer $user_id
	 * @return string $full_name
	 */
	public static function full_name($user_id)
	{
		// Get User
		$user = User::where('id', $user_id)->first();

		if ($user) {
			// Get Full Name
			return $user->first_name.' '.$user->last_name;
		}else{
			return 'N/A';
		}

		
	}

	/**
	 * Get User Full Name
	 * @param string $username
	 * @return string $full_name
	 */
	public static function full_name_by_username($username)
	{
		// Get User
		$user = User::where('username', $username)->first();

		if ($user) {
			
			// Get Full Name
			return $user->first_name.' '.$user->last_name;

		}else{

			return 'N/A';

		}
		
	}

	/**
	 * Get User First Name
	 * @param integer $user_id
	 * @return string $first_name
	 */
	public static function first_name($user_id)
	{
		// Get User
		$user = User::where('id', $user_id)->first();

		if ($user) {
			// Get First Name
			return $user->first_name;
		}else{
			return 'N/A';
		}

	}

	/**
	 * Check if user has store
	 * @param integer $user_id
	 * @return string $store
	 */
	public static function hasStore($user_id)
	{
		$user = User::where('id', $user_id)->first();

        if ($user->has_store) {

        	// Get Store
        	$store = Store::where('owner_id', $user_id)->where('status', 1)->first();

        	if ($store) {
        		return $store;
        	}else{
        		return false;
        	}
         
        }

        return FALSE;
	}

	/**
	 * Get User Phone Number
	 * @param integer $user_id
	 * @return string $phone
	 */
	public static function phone($user_id)
	{
		// Get User
		$user = User::where('id', $user_id)->first();

		if ($user) {
			// Get Phone
			return $user->phone;
		}else{
			return 'N/A';
		}

	}

	/**
	 * Check if user active
	 * @param integer $user_id
	 * @return boolean 
	 */
	public static function isActive($user_id)
	{
		// Get User
		$user = User::where('id', $user_id)->first();

		if ($user && $user->status) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Get Store Cover
	 * @param $cover string
	 * @return $cover $string
	 */
	public static function cover($cover)
	{
		// Check cover
		if ($cover == "store_cover.png") {

			// Default Cover
			return Protocol::home().'/application/public/uploads/covers/default_cover.jpg';

		}else{

			// Store Cover
			return $cover;
			
		}
	}

	/**
	 * Get Store Cover
	 * @param $cover string
	 * @return $cover $string
	 */
	public static function cover_by_id($id)
	{
		// Get user
		$user = Store::where('owner_id', $id)->first();

		// Check cover
		if ($user->cover == "store_cover.png") {

			// Default Cover
			return Protocol::home().'/application/public/uploads/covers/default_cover.jpg';

		}else{

			// Store Cover
			return $user->cover;
			
		}
	}
}