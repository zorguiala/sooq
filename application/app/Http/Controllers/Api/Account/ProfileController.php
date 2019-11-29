<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\User;
use Hash;
use Spam;

class ProfileController extends Controller
{
    
    /**
     * Get user profile
     * @return [type] [description]
     */
	public function profile()
	{
		// Get profile
		$profile = auth()->user();

		return response()->json(['profile' => $profile], 200, []);
	}

	/**
	 * Update user profile
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function settings(Request $request)
	{
		// Get user id
		$user_id = auth()->id();

		// Make rules
		$rules = array(
			'first_name'   => 'required|max:255|min:2', 
            'last_name'    => 'required|max:255|min:2',
			'username'     => [
				'required',
				'min:3',
				'max:255',
				Rule::unique('users')->ignore($user_id)
			],
			'email'        => [
				'required', 
				'email',
				'max:255',
				Rule::unique('users')->ignore($user_id)
			], 
			'phone'        => 'required|numeric',
			'gender'       => 'required|boolean', 
			'country'      => 'required|exists:countries,sortname', 
			'state'        => 'numeric|exists:states,id', 
			'city'         => 'numeric|exists:cities,id', 
			'phonecode'    => 'required|numeric|exists:countries,phonecode', 
			'avatar'       => 'image|mimes:png,jpg,jpeg|max:2000', 
			'old_password' => 'required_with:new_password|min:6|max:200', 
			'new_password' => 'required_with:old_password|min:6|max:200',
		);

		// Make validation
		$request->validate($rules);

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
		$avatar            = $request->file('avatar');
		$old_password      = $request->get('old_password');
		$new_password      = $request->get('new_password');
		$full_phone_format = '+'.$phonecode.$phone;

		// Check Spam Email
        if (Spam::email($email)) {

            // Spam email detected
            $response = array(
                'status'  => false, 
                'message' => 'Oops! Our system have detected a spam email. Please try again.' 
            );

            return response()->json($response, 422, []);

        }

        // Check if username on our blacklist
        if (Spam::blacklist_username($username)) {

            // Spam email detected
            $response = array(
                'status'  => false, 
                'message' => 'Oops! The given username listed in blacklist. Please try again.' 
            );

            return response()->json($response, 422, []);

        }

        // Check phone number
        try {
    
            if (!PhoneNumber::make($full_phone_format)->isOfCountry($country)) {
                
                // Spam email detected
                $response = array(
                    'status'  => false, 
                    'message' => 'Oops! Invalid phone number. Please try again.' 
                );

                return response()->json($response, 422, []);

            }

        } catch (\Exception $e) {
            
            // Spam email detected
            $response = array(
                'status'  => false, 
                'message' => 'Oops! Invalid phone number. Please try again.' 
            );

            return response()->json($response, 422, []);

        }
		
		// Check if user wants to change password
		if ($new_password) {
			
			// Check password
			if (Hash::check($old_password, auth()->user()->password)) {

				// Update password
				User::where('id', $user_id)->update([
					'password' => Hash::make($new_password)
				]);

			}else{

				// Error, make response
				$response = array(
					'status'  => false, 
					'message' => 'Oops! You old password does not match your current one. Please try again.', 
				);

				return response()->json($response, 422, []);

			}

		}
		
		// Check if avatar included with request params
		if ($avatar) {
			// Nothing here right now
		}

		// Update user
		User::where('id', $user_id)->update([
			'first_name'   => $first_name,
			'last_name'    => $last_name,
			'username'     => $username,
			'email'        => $email,
			'phone'        => $phone,
			'phonecode'    => $phonecode,
			'gender'       => $gender,
            'country_code' => $country,
            'state'        => $state,
            'city'         => $city,
		]);	

		// Success, make response
		$response = array(
			'status'  => true, 
			'message' => 'Congratulations! Your profile has been successfully updated.', 
		);

		return response()->json($response, 200, []);

	}

}
