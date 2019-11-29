<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spam;
use Purifier;
use DB;
use Carbon\Carbon;

class ContactController extends Controller
{
    
	public function contact(Request $request)
	{
		// Make rules
    	$rules = array(
			'full_name' => 'required', 
			'email'     => 'required|email', 
			'phone'     => 'phone:AUTO', 
			'subject'   => 'required', 
			'message'   => 'required', 
    	);

    	$request->validate($rules);

    	// Get Inputs values
		$full_name = $request->get('full_name');
		$email     = $request->get('email');
		$phone     = $request->get('phone');
		$message   = Purifier::clean($request->get('message'));
		$subject   = $request->get('subject');

        // Check spam email
        if (Spam::email($email)) {

        	// Error, make response
        	$response = array(
        		'status'  => false, 
        		'message' => __('return/error.lang_system_detected_spam_email'), 
        	);

            return response()->json($response, 422, []);

        }

		// Send Message to admin
		DB::table('admin_mailbox')->insert([
			'full_name'  => $full_name,
			'email'      => $email,
			'phone'      => $phone,
			'message'    => $message,
			'subject'    => $subject,
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		]);

		// Suucess, make response
    	$response = array(
    		'status'  => true, 
    		'message' => 'Your message has been successfully sent.', 
    	);

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
	}

}
