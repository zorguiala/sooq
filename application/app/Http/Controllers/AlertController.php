<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Validator;
use Spam;
use DB;
use Carbon\Carbon;

class AlertController extends Controller
{
    
	/**
	* Create new keyword alert
	*/
	public function create(Request $request)
	{
		
		// Check if ajax request
		if ($request->ajax()) {
			
			// Make rules
			$rules = array(
				'email'   => 'required|email', 
				'keyword' => 'required|max:100', 
			);

			// Run Validator
			$validator = Validator::make($request->all(), $rules);

			if ($validator->passes()) {
				
				// Get Inputs
				$email   = $request->get('email');
				$keyword = $request->get('keyword');

				// check spam email
				if (Spam::email($email)) {
					
					// Error
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_system_detected_spam_email')
					);

					return Response::json($response);

				}

				// Check if keyword and email already exists in our database
				$check = DB::table('search_alert')->where('keyword', $keyword)
												  ->where('email', $email)
												  ->first();

				if ($check) {

					// Error
					$response = array(
						'status' => 'error', 
						'msg'    => 'Oops! Alert already exists! Please try again.'
					);

					return Response::json($response);

				}else{

					// Create New alert
					DB::table('search_alert')->insert([
						'keyword'    => $keyword,
						'email'      => $email,
						'token'      => str_random(40),
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now(),
					]);

					// Success
					$response = array(
						'status' => 'success', 
						'msg'    => 'Alert has been successfully created.'
					);

					return Response::json($response);

				}

			}else{

				// Error
				$response = array(
					'status' => 'errors',
					'errors' => $validator->getMessageBag()->toArray()
				);

				return Response::json($response);

			}

		}

	}

	/*
	* Deletec Alert
	*/
	public function delete(Request $request)
	{
		
		// Get token
		$token = $request->get('token');

		// Check if alert exists
		$alert = DB::table('search_alert')->where('token', $token)->first();

		if ($alert) {
			
			// Delete alert
			$alert->delete();

			// success
			return redirect('/')->with('success', 'Alert has been successfully deleted.');

		}else{

			// Not found
			return redirect('/')->with('error', 'Oops! Alert not found');

		}

	}

}
