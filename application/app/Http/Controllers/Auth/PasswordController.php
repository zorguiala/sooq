<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\PasswordReminder;
use App\User;
use Carbon\Carbon;
use Validator;
use DB;
use Hash;
use Protocol;
use SEO;
use SEOMeta;
use Helper;
use Theme;

class PasswordController extends Controller
{
    public $theme = '';

    public function __construct()
    {
        $this->middleware('guest');
        $this->theme = Theme::get();
    }

    /*********** Reset Password ***********/
    public function reset()
    {
        // Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_reset_password').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

        return view($this->theme.'.auth.password.reset');
    }

    /**
     * Send Email password reset link
     */
    public function email(Request $request)
    {

        // Recaptcah rule
        $recaptcha_rule = Helper::settings_security()->recaptcha ? 'required|captcha' : '';

    	// Make Validation
    	$validator = Validator::make($request->all(), [
            'email'                => 'required|email',
            'g-recaptcha-response' => $recaptcha_rule,
    	]);

    	if ($validator->fails()) {
    		// Error
    		return redirect('/auth/password/reset')->withErrors($validator);
    	}else{

    		// Get email
    		$email = $request->get('email');

    		// Get user
    		$user = User::where('email', $email)->first();

    		if ($user) {
    			
    			// Generate token
    			$token = str_random(64);

    			// Create new password reset 
    			DB::table('password_resets')->insert([
					'email'      => $email,
					'token'      => $token,
					'created_at' => Carbon::now()
    			]);

    			// Send Notification
    			$user->notify(new PasswordReminder($token, $email));

    			// Not found
    			return redirect('/auth/password/reset')->with('success', __('return/success.lang_you_will_receive_email_link_if_account_exists'));

    		}else{

    			// Not found
    			return redirect('/auth/password/reset')->with('success', __('return/success.lang_you_will_receive_email_link_if_account_exists'));

    		}

    	}
    }

    /**
     * Update Password
     */
    public function update(Request $request)
    {
    	// Get Email && Token
    	$token = $request->get('token');
    	$email = $request->get('email');

    	// Check password link
    	$check = DB::table('password_resets')->where('token', $token)->where('email', $email)->where('is_used', 0)->first();

    	if ($check) {
    		
    		// Get expired link minutes
			$expired_minutes = config('auth.passwords.users.expire');
			
			// Check if password link expired
			$created         = new Carbon($check->created_at);
			$now             = Carbon::now();
			$created->diffInMinutes($now);

			if ($created->diffInMinutes($now) > $expired_minutes) {
				
				// Link expired
				return redirect('/auth/password/reset')->with('error', __('return/error.lang_activation_expired'));

			}else{

                // Get Tilte && Description
                $title      = Helper::settings_general()->title;
                $long_desc  = Helper::settings_seo()->description;
                $keywords   = Helper::settings_seo()->keywords;

                // Manage SEO
                SEO::setTitle(__('title.lang_update_password').' | '.$title);
                SEO::setDescription($long_desc);
                SEO::opengraph()->setUrl(Protocol::home());
                SEOMeta::addKeyword([$keywords]);

				// Update Password
				return view($this->theme.'.auth.password.update')->with([
					'token' => $token,
					'email' => $email,
				]);

			}


    	}else{

    		// Not found
    		return abort(404);

    	}
    }

    /**
     * Update Password
     */
    public function new_pass(Request $request)
    {
    	// Get Email && Token
    	$token = $request->get('token');
    	$email = $request->get('email');

    	// Check password link
    	$check = DB::table('password_resets')->where('token', $token)->where('email', $email)->where('is_used', 0)->first();

    	if ($check) {
    		
    		// Get expired link minutes
			$expired_minutes = config('auth.passwords.users.expire');
			
			// Check if password link expired
			$created         = new Carbon($check->created_at);
			$now             = Carbon::now();
			$created->diffInMinutes($now);

			if ($created->diffInMinutes($now) > $expired_minutes) {
				
				// Link expired
				return redirect('/auth/password/reset')->with('error', __('return/error.lang_activation_expired'));

			}else{

                // Recaptcah rule
                $recaptcha_rule = Helper::settings_security()->recaptcha ? 'required|captcha' : '';

				// Make Rules
				$rules = array(
                    'password'             => 'required|min:6|confirmed', 
                    'g-recaptcha-response' => $recaptcha_rule,
				);

				// Make Validation
				$validator = Validator::make($request->all(), $rules);

				if ($validator->fails()) {
					
					// Error
					return back()->withErrors($validator);

				}else{

					// Update Password
					User::where('email', $email)->update([
						'password' => Hash::make($request->get('password'))
					]);

					// Mark this token as used
					DB::table('password_resets')->where('token', $token)->where('email', $email)->update([
						'is_used' => 1
					]);

					// Success
					return redirect('/auth/login')->with('success', __('return/success.lang_password_updated'));

				}

			}


    	}else{

    		// Not found
    		return abort(404);

    	}
    }
}
