<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\PasswordReminder;
use Carbon\Carbon;
use DB;
use App\User;

class PasswordController extends Controller
{
    
    /**
     * Reset password
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function reset(Request $request)
    {
    	// Validate request
    	$request->validate([
    		'email' => 'required|email'
    	]);

    	// Get email
    	$email = $request->get('email');

    	// Check if user exists
    	$user = User::where('email', $email)->first();

    	if ($user) {
    		
    		// User found, send him a password reminder link
    		$token = str_random(64);

			// Create new password reset 
			DB::table('password_resets')->insert([
				'email'      => $email,
				'token'      => $token,
				'created_at' => Carbon::now()
			]);

			// Send Notification
			$user->notify(new PasswordReminder($token, $email));

			// Not found, make response
    		$response = array(
    			'status'  => true,
    			'message' => __('return/success.lang_you_will_receive_email_link_if_account_exists') 
    		);

    		return response()->json($response, 200, []);

    	}else{

    		// Not found, make response
    		$response = array(
    			'status'  => true,
    			'message' => __('return/success.lang_you_will_receive_email_link_if_account_exists') 
    		);

    		return response()->json($response, 200, []);

    	}
    }

}
