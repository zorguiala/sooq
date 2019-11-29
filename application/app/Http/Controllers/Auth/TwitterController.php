<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Socialite;
use Auth;
use App\User;
use IP;
use Carbon\Carbon;
use Uploader;
use Config;
use Countries;
use DB;

class TwitterController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Redirect the user to the twitter authentication page.
     *
     * @return Response
     */
    public function redirect()
    {
		return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function callback()
    {
        try {

            $user = Socialite::driver('twitter')->user();

        } catch (Exception $e) {

            return redirect('auth/twitter');
            
        }

        if (empty($user->email)) {
            return redirect('auth/login')->with('error', 'Oops! E-mail address is empty.');
        }
 
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
     * @param $twitterUser
     * @return User
     */
    private function findOrCreateUser($twitterUser)
    {
        $authUser = User::where('twitter_id', $twitterUser->id)->first();

        if ($authUser){
            return $authUser;
        }

        // Check if email already taken
        $check_email = User::where('email', $twitterUser->email)->orWhere('username', $twitterUser->nickname)->first();

        if ($check_email) {
            
            // Make response
            $response = array(
                'status'  => false,
                'message' => 'Oops! E-mail address or username already taken.'
            );
            return $response;

        }

        // Get first && last name
		$parts      = explode(" ", $twitterUser->name);
		$last_name  = array_pop($parts);
		$first_name = implode(" ", $parts);

		// Check first name
		if (!$first_name) {
			$first_name = 'Unknown';
		}

        // Get Geo Settings
        $geo_settings = DB::table('settings_geo')->where('id', 1)->first();

        return User::create([
			'username'      => $twitterUser->nickname,
			'twitter_id'    => $twitterUser->id,
			'avatar'        => Uploader::upload_avatar_url($twitterUser->avatar_original, $twitterUser->nickname),
			'first_name'    => $first_name,
			'last_name'     => $last_name,
			'email'         => $twitterUser->email,
            'country_code'  => Countries::country_code($geo_settings->default_country),
            'state'         => $geo_settings->default_state,
            'city'          => $geo_settings->default_city,
			'gender'        => 1,
			'status'        => 1,
			'last_login_ip' => IP::get(),
			'last_login_at' => Carbon::now(),
        ]);
    }

}