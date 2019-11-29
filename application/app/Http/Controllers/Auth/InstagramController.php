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

class InstagramController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Redirect the user to the Instagram authentication page.
     *
     * @return Response
     */
    public function redirect()
    {
        return Socialite::with('instagram')->stateless(false)->redirect();
    }

    /**
     * Obtain the user information from Instagram.
     *
     * @return Response
     */
    public function callback()
    {
        $user = Socialite::driver('instagram')->stateless(false)->user();

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
     * @param $instagramUser
     * @return User
     */
    private function findOrCreateUser($instagramUser)
    {
        $authUser = User::where('instagram_id', $instagramUser->id)->first();

        if (!$authUser){

	        // Get User Info
	        $username = $instagramUser->accessTokenResponseBody['user']['username'];
	        $avatar   = Uploader::upload_avatar_url($instagramUser->accessTokenResponseBody['user']['profile_picture'], $instagramUser->accessTokenResponseBody['user']['username']);
	        $email    = $username.'@instagram.com';
	        $instagram_id = $instagramUser->accessTokenResponseBody['user']['id'];
	        $gender = 1;
	        // Get first && last name
			$parts      = explode(" ", $instagramUser->accessTokenResponseBody['user']['full_name']);
			$last_name  = array_pop($parts);
			$first_name = implode(" ", $parts);
			$website = $instagramUser->accessTokenResponseBody['user']['website'];

	        // Check if email already taken
	        $check_email = User::where('username', $instagramUser->accessTokenResponseBody['user']['username'])->orWhere('email', $email)->first();

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
	            'instagram_id'   => $instagram_id,
	            'avatar'        => $avatar,
	            'gender'        => $gender,
	            'status'        => 1,
	            'website'       => $website,
	            'last_login_ip' => IP::get(),
	            'last_login_at' => Carbon::now(),
	        ]);

    	}else{
    		return $authUser;
    	}
    }

}
