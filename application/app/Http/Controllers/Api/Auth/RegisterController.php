<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SMSActivationCode;
use App\Notifications\EmailActivation;
use IP;
use Carbon\Carbon;
use Helper;
use Spam;
use DB;
use Random;

class RegisterController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct()
    {
		$this->client = Client::where('id', 2)->first();
	}

    public function register(Request $request)
    {

    	$this->validate($request, [
    		'first_name'            => 'required|max:255|min:2', 
            'last_name'             => 'required|max:255|min:2',
            'username'              => 'required|max:255|unique:users',
            'email'                 => 'required|email|unique:users',
            'phone'                 => 'required|numeric|unique:users',
            'phonecode'             => 'required|numeric|exists:countries,phonecode',
            'country'               => 'required|exists:countries,sortname', 
            'state'                 => 'numeric|exists:states,id', 
            'city'                  => 'numeric|exists:cities,id', 
            'gender'                => 'required|boolean',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
    	]);

        // Get inputs values
        $first_name        = $request->get('first_name');
        $last_name         = $request->get('last_name');
        $username          = $request->get('username');
        $password          = $request->get('password');
        $email             = $request->get('email');
        $phone             = $request->get('phone');
        $phonecode         = $request->get('phonecode');
        $gender            = $request->get('gender');
        $country           = $request->get('country');
        $state             = $request->get('state');
        $city              = $request->get('city');
        $city              = $request->get('city');
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

        // Check if user need activation
        if (Helper::settings_auth()->need_activation) {
            $status = false;
        }else{
            $status = true;
        }

        // Create user
        $user = User::create([
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'username'      => $username,
            'email'         => $email,
            'gender'        => $gender,
            'country_code'  => $country,
            'state'         => $state,
            'city'          => $city,
            'phone'         => $phone,
            'phonecode'     => $phonecode,
            'status'        => $status,
            'last_login_ip' => IP::get(),
            'last_login_at' => Carbon::now(),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
            'password'      => bcrypt($password)
        ]);

        // Check if user need activation
        if (Helper::settings_auth()->need_activation) {
            
            // Check if need activation via email
            if (Helper::settings_auth()->activation_type == 'email') {
                
                // Generate Activation link
                $activation_code = Random::activation_code($request->get('email'));

                // Send Email Activation Key
                $user->notify(new EmailActivation($activation_code, $username));

                // Save Activation Code in Database
                DB::table('activations')->insert([
                    'email'      => $email,
                    'phone'      => $phonecode.$phone,
                    'key'        => $activation_code,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // success Register
                $response = array(
                    'status'  => true, 
                    'message' => 'Congratulations! Your account has been successfully created. Please check your email and verify your email address.', 
                );

                return response()->json($response, 204, []);

            }else{

                // Send Notitifaction to Admins
                DB::table('notifications_users')->insert([
                    'user_id'    => $user->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // success Register
                $response = array(
                    'status'  => true, 
                    'message' => 'Congratulations! Your account has been successfully created and will be active shortly.', 
                );

                return response()->json($response, 204, []);

            }

        }else{

            // Auto login after register
            return $this->issueToken($request, 'password');

        }

    }
}