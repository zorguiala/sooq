<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Notifications\NewSignIn;
use Illuminate\Support\Facades\Mail;
use App\Models\Ad;
use Redirect;
use Validator;
use Auth;
use Input;
use App\User;
use Carbon\Carbon;
use SEO;
use SEOMeta;
use Helper;
use Protocol;
use Tracker;
use IP;
use DB;
use Theme;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
 
    use AuthenticatesUsers;
 
    /**
     * Auth guard
     *
     * @var
     */
    protected $auth;
     
     /**
     * lockoutTime
     *
     * @var
     */
    protected $lockoutTime;
     
    /**
     * maxLoginAttempts
     *
     * @var
     */
    protected $maxLoginAttempts;
 
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    
    public $theme         = '';

    public function __construct(Guard $auth)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->theme            = Theme::get();
        $this->auth             = $auth;
        $this->lockoutTime      = Helper::settings_security()->unlock_time;
        $this->maxLoginAttempts = Helper::settings_security()->max_attempts;
    }


    /*********** Get Login ***************/
    public function getLogin()
    {
        // Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $short_desc = Helper::settings_general()->description;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_login').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home().'/auth/login');
        SEOMeta::addKeyword([$keywords]);

        return view($this->theme.'.auth.login');
    }

    /*********** Submit Login Request ************/
    public function postLogin(Request $request)
    {

        // Recaptcah rule
        $recaptcha_rule = Helper::settings_security()->recaptcha ? 'required|captcha' : '';

        // validate the info, create rules for the inputs
        $rules = array(
            'email'                => 'required|email',
            'password'             => 'required', 
            'g-recaptcha-response' => $recaptcha_rule,
        );

        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails
        if ($validator->fails()) {

            return Redirect::to('auth/login')
                ->withErrors($validator)
                ->withInput(Input::except('password'));

        }else{

            try {

                // Check if the user has surpassed their allowed maximum of login attempts
                if ($this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);
                    return $this->sendLockoutResponse($request);
                }

                // create our user data for the authentication
                $userdata = array(
                    'email'     => Input::get('email'),
                    'password'  => Input::get('password')
                );

                // Remember me?
                $remember = (Input::has('remember')) ? true : false;

                // attempt to do the login
                if (Auth::attempt($userdata, $remember)) {

                    // Check if account active
                    if (!Auth::user()->status) {
                        // Logout
                        $this->guard()->logout();
                        $request->session()->flush();
                        $request->session()->regenerate();

                        // Not active
                        return redirect('/auth/login')->with('error', __('return/error.lang_account_not_active'));
                    }

                    // Get user email
                    $email         = Input::get('email');
                    
                    // Get User Last sign
                    $last_login    = User::where('email', $email)->first();
                    
                    // Get this login ip
                    $this_login_ip = IP::get();

                    // Check last ip and this ip
                    if ($last_login->last_login_ip != $this_login_ip) {

                        // Update last login
                        User::where('email', $email)->update([
                            'last_login_ip' => $this_login_ip,
                            'last_login_at' => Carbon::now()
                        ]);

                        // Get this user
                        $user = User::where('email', $email)->first();

                        // Send notification to this user
                        $user->notify(new NewSignIn($this_login_ip));

                    }

                    // the login attempt was successful we redirect. but first, we clear the login attempts session
                    $request->session()->regenerate();
                    $this->clearLoginAttempts($request);

                    // Check if redirect to ad
                    if ($request->get('redirect')) {
                        
                        // check if ad exists
                        $ad = Ad::where('ad_id', $request->get('redirect'))->first();

                        if ($ad) {
                           
                            // Redirect to ad
                            return redirect(Protocol::home().'/listing/'.$ad->slug);

                        }else{

                            // Ad not found
                            return Redirect::to('/');

                        }

                    }

                    return Redirect::to('/');

                }else{        

                    // Get visitor info
                    $ip_address = IP::get();
                    $country    = Tracker::ip($ip_address)->country();
                    $city       = Tracker::ip($ip_address)->city();

                    // Insert Invalid Login 
                    DB::table('failed_login')->insert([
                        'email'      => Input::get('email'),
                        'ip_address' => $ip_address,
                        'country'    => $country,
                        'city'       => $city,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    // the login attempt was unsuccessful we will increment the number of attempts
                    $this->incrementLoginAttempts($request);

                    // validation not successful, send back to form 
                    return Redirect::to('auth/login')->with('error', __('return/error.lang_login_incorrect_details'))->withInput(Input::except('password'));

                }

            
                
            } catch (\Exception $e) {
                return redirect('/auth/login')->with('error', $e->getMessage());
            }
            
        }
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxLoginAttempts, $this->lockoutTime
        );
    }
}
