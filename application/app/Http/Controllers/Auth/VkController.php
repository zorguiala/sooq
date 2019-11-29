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

class VkController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Redirect the user to the vk authentication page.
     *
     * @return Response
     */
    public function redirect()
    {
		return Socialite::with('vkontakte')->stateless(false)->redirect();
    }

    /**
     * Obtain the user information from vk.
     *
     * @return Response
     */
    public function callback()
    {
        $user = Socialite::driver('vkontakte')->stateless(false)->user();

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
     * @param $vkUser
     * @return User
     */
    private function findOrCreateUser($vkUser)
    {
        $authUser = User::where('vk_id', $vkUser->id)->first();

        if ($authUser){
            return $authUser;
        }

        // Check if email already taken
        $check_email = User::where('email', $vkUser->email)->orWhere('username', $vkUser->nickname)->first();

        if ($check_email) {
            
            // Make response
            $response = array(
                'status'  => false,
                'message' => 'Oops! E-mail address or username already taken.'
            );
            return $response;

        }

        // Get first && last name
		$parts      = explode(" ", $vkUser->name);
		$last_name  = array_pop($parts);
		$first_name = implode(" ", $parts);

		// Check first name
		if (!$first_name) {
			$first_name = 'Unknown';
		}

		// Get Geo Settings
        $geo_settings = DB::table('settings_geo')->where('id', 1)->first();

        return User::create([
			'username'      => $vkUser->nickname,
			'vk_id'         => $vkUser->id,
			'avatar'        => Uploader::upload_avatar_url($vkUser->avatar, $vkUser->nickname),
			'first_name'    => $first_name,
			'last_name'     => $last_name,
			'email'         => $vkUser->email,
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
