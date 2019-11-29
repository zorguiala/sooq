<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\User;
use IP;
use Carbon\Carbon;
use DB;
use Countries;

class PinterestController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Redirect the user to the Pinterest authentication page.
     *
     * @return Response
     */
    public function redirect()
    {
        return Socialite::with('pinterest')->stateless(false)->redirect();
    }

    /**
     * Obtain the user information from Pinterest.
     *
     * @return Response
     */
    public function callback()
    {
        $user = Socialite::driver('pinterest')->stateless(false)->user();

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
     * @param $pinterestUser
     * @return User
     */
    private function findOrCreateUser($pinterestUser)
    {
        $authUser = User::where('pinterest_id', $pinterestUser->id)->first();

        if (!$authUser){

	        // Get User Info
			$username     = $pinterestUser->nickname;
			$avatar       = 'avatar.png';
			$email        = $username.'@pinterest.com';
			$pinterest_id = $pinterestUser->id;
			$gender       = 1;
			$last_name    = $pinterestUser->user['data']['last_name'];
			$first_name   = $pinterestUser->user['data']['first_name'];
			
			// Check if email already taken
			$check_email  = User::where('username', $pinterestUser->nickname)->orWhere('email', $email)->first();

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
	            'pinterest_id'  => $pinterest_id,
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
