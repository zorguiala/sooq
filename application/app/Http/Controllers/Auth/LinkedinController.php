<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\User;
use IP;
use Carbon\Carbon;
use Uploader;
use DB;
use Countries;

class LinkedinController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Redirect the user to the LinkedIn authentication page.
     *
     * @return Response
     */
    public function redirect()
    {
        return Socialite::with('linkedin')->stateless(false)->redirect();
    }

    /**
     * Obtain the user information from LinkedIn.
     *
     * @return Response
     */
    public function callback()
    {
        $user = Socialite::driver('linkedin')->stateless(false)->user();

        $authUser = $this->findOrCreateUser($user);

        if (!$authUser['status']) {
            
            // error
            return redirect('/auth/login')->with('error', $authUser['message']);

        }

        Auth::login($authUser, true);

        return redirect('/');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $linkedinUser
     * @return User
     */
    private function findOrCreateUser($linkedinUser)
    {
        $authUser = User::where('linkedin_id', $linkedinUser->id)->first();

        if (!$authUser){

            //return var_dump($linkedinUser);

	        // Get User Info
	        $username = str_slug($linkedinUser->name, '_');
	        $avatar   = Uploader::upload_avatar_url($linkedinUser->avatar, $username);
	        $email    = $linkedinUser->email;
	        $linkedin_id = $linkedinUser->id;
	        $gender = 1;
	        // Get first && last name
			$parts      = explode(" ", $linkedinUser->name);
			$last_name  = array_pop($parts);
			$first_name = implode(" ", $parts);

	        // Check if email already taken
	        $check_email = User::where('email', $email)->orWhere('username', $username)->first();

	        if ($check_email) {
	            
	            // Make response
                $response = array(
                    'status'  => false,
                    'message' => 'Oops! E-mail address or username already taken.'
                );
                return $response;

	        }

            // Get Geo Settings
            $geo_settings = DB::table('settings_geo')->where('id', 1)->first();

	        return User::create([
	            'username'      => $username,
	            'first_name'    => $first_name,
	            'last_name'     => $last_name,
	            'email'         => $email,
                'country_code'  => Countries::country_code($geo_settings->default_country),
                'state'         => $geo_settings->default_state,
                'city'          => $geo_settings->default_city,
	            'linkedin_id'   => $linkedin_id,
	            'avatar'        => $avatar,
	            'gender'        => $gender,
	            'status'        => 1,
	            'last_login_ip' => IP::get(),
	            'last_login_at' => Carbon::now(),
	        ]);

    	}else{
    		return $authUser;
    	}
    }

}
