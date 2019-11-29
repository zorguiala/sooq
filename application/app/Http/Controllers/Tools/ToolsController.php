<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendToFriend;
use Illuminate\Support\Facades\Mail;
use App\Models\Ad;
use App\Models\State;
use App\Models\Country;
use App\Models\City;
use Newsletter;
use Response;
use Validator;
use DB;
use Spam;
use Session;
use Helper;
use Carbon\Carbon;

/**
 * ToolsController
 */

class ToolsController extends Controller
{

	/**
	 * Subscribe to newsletter
	 */
	public function newsletter(Request $request)
	{
		// Check if ajax request
		if ($request->ajax()) {
			
			// Check email
			$validator = Validator::make($request->all(), [
				'email' => 'required|email'
			]);

			if ($validator->fails()) {
				// error
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_insert_valid_email'), 
				);
				return Response::json($response);
			}else{

				// Check spam email
				if (Spam::email($request->get('email'))) {
					// error
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_system_detected_spam_email'), 
					);
					return Response::json($response);
				}

				// Check if already subscribed
				if (Newsletter::hasMember($request->get('email'))) {
					// error
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_email_already_exists'), 
					);
					return Response::json($response);
				}

				// Subscribe user
				Newsletter::subscribeOrUpdate($request->get('email'));

				// success
				$response = array(
					'status' => 'success', 
					'msg'    => __('return/success.lang_email_added_to_list'), 
				);
				return Response::json($response);

			}

		}
	}

	/**
	 * States By country
	 */
	public static function states_by_country(Request $request)
	{
		// Check if ajax request
		if ($request->ajax()) {

			// Get Country ID
			$country_id = $request->get('country_id');
			
			// Check country id
			$country = Country::where('sortname', 
				$country_id)->orWhere('id', $country_id)->first();

			if (!$country) {
				// Error
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_country_not_found'), 
				);
				return Response::json($response);
			}

			// Get GEO Settings
			$settings = Helper::settings_geo();

			// Check if states enabled
			if ($settings->states_enabled) {
				
				// Get states
				$states = State::where('country_id', $country->id)->get();

				// Success
				$response = array(
					'status'    => 'success', 
					'states'    => true, 
					'data'      => $states, 
					'phonecode' => $country->phonecode, 
				);
				return Response::json($response);

			}else{

				// States not enabled, check cities
				if ($settings->cities_enabled) {
					
					// Get cities
					$cities = City::where('country_id', $country->id)->get();

					// Success
					$response = array(
						'status'    => 'success', 
						'cities'    => true, 
						'data'      => $cities, 
						'phonecode' => $country->phonecode, 
					);
					return Response::json($response);

				}else{

					/*// States and cities are not enabled, sorry
					$response = array(
						'status' => 'error', 
						'msg'    => 'Oops! States and cities are not enabled.', 
					);*/
					return;

				}

			}

			

		}
	}

	/**
	 * cities by state
	 */
	public static function cities_by_state(Request $request)
	{
		// Check if ajax request
		if ($request->ajax()) {

			// Get State ID
			$state_id = $request->get('state_id');
			
			// Check state id
			$state = DB::table('states')->where('id', 
				$state_id)->first();

			if (!$state) {
				// Error
				$response = array(
					'status' => 'error', 
					'msg'    => __('return/error.lang_state_not_found'), 
				);
				return Response::json($response);
			}

			// Get cities
			$cities = DB::table('cities')->where('state_id', $state_id)->get();

			// Success
			$response = array(
				'status' => 'success', 
				'data'   => $cities, 
			);
			return Response::json($response);

		}
	}

	/**
	 * Send Ad to a friend
	 */
	public function send(Request $request)
	{
		// Check ajax request
		if ($request->ajax()) {
			
			// Please wait 10 minutes to send next message
			$last_message_date    = Session::get('last_message_date');

			if (isset($last_message_date)) {
			
				// Check if expired
				$carbon_date          = new Carbon($last_message_date);
				
				$cDate                = Carbon::parse($carbon_date);
				
				$last_message_minutes = $cDate->diffInMinutes();

				if ($last_message_minutes < 10 ) {

					// Error
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_wait_time_for_next_message')
					);

					return Response::json($response);
				}

			}

			// Make rules
			$rules = array(
				'senderEmail'    => 'required|email', 
				'friendEmail'    => 'required|email', 
				'messageContent' => 'required'
			);

			// Make validation
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				// Error
				$response = array(
					'status' => 'errors', 
					'errors' => $validator->getMessageBag()->toArray()
				);

				return Response::json($response);
			}else{

				// Get Inputs
				$senderEmail    = $request->get('senderEmail');
				$friendEmail    = $request->get('friendEmail');
				$messageContent = $request->get('messageContent');
				$ad_id          = $request->get('ad_id');

				// Check if ad exists
				$ad = Ad::where('ad_id', $ad_id)->where('status', 1)->where('is_trashed', 0)->first();

				if (!$ad) {
						
					// Not found
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_ad_not_found')
					);

					return Response::json($response);

				}

				// Check Spam Emails
				if (Spam::email($senderEmail) OR Spam::email($friendEmail)) {
					
					// Spam
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_system_detected_spam_email')
					);

					return Response::json($response);

				}

				// Sender email equal friend email
				if ($senderEmail == $friendEmail) {
					// error
					$response = array(
						'status' => 'error', 
						'msg'    => __('return/error.lang_something_went_wrong')
					);

					return Response::json($response);
				}

				// Send Message to friend
				$data = array(
					'senderEmail'    => $senderEmail, 
					'friendEmail'    => $friendEmail, 
					'messageContent' => $messageContent, 
					'ad_id'          => $ad_id, 
				);

				Mail::to($friendEmail)->send(new SendToFriend($data));

				// Clear old sessions
                $request->session()->flush();
                $request->session()->regenerate();

				// Prenvent Multiple requests
				Session::put('last_message_date', Carbon::now());

				// success
				$response = array(
					'status' => 'success', 
					'msg'    => __('return/success.lang_message_sent')
				);

				return Response::json($response);

			}

		}
	}

}