<?php



namespace App\Http\Controllers\Auth;



use App\User;

use App\Models\Country;

use App\Models\State;

use App\Models\City;

use Validator;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\RegistersUsers;

use Session;

use Illuminate\Support\Facades\Mail;

use App\Notifications\SMSActivationCode;

use App\Notifications\EmailActivation;

use Auth;

use Redirect;

use Input;

use DB;

use IP;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Spam;

use Random;

use Helper;

use Illuminate\Auth\Events\Registered;

use Propaganistas\LaravelPhone\PhoneNumber;

use AuthenticatesAndRegistersUsers, ThrottlesLogins;

use RedirectsUsers;

use Protocol;

use SEO;

use SEOMeta;

use Theme;

use Tracker;



class RegisterController extends Controller

{

    public $theme = '';



    public function __construct()

    {

        $this->middleware('guest');

        $this->theme = Theme::get();

    }



    /**

     * Where to redirect users after login / registration.

     *

     * @var string

     */

    protected $redirectTo = '/';



    /********* Get Register ***********/

    public function getRegister()

    {



        // Get GEO Settings

        $settings_geo = Helper::settings_geo();



        // Detect country

        $detectedCountry = Tracker::ip(IP::get())->country_code();



        // Check if country exists

        $country = Country::where('sortname', $detectedCountry)->first();




            // Check if site set for one country or multiple

            if ($settings_geo->is_international) {

                

                // Get countries

                $countries = Country::all();

                

                // Get States

                $states    = State::where('country_id', $settings_geo->default_country)->get();

                

                // Get Cities

                $cities    = City::where('country_id', $settings_geo->default_state)->get();



            }else{



                // Get default country

                $countries = Country::where('id', $settings_geo->default_country)->get();

                

                // Get states

                $states    = State::where('country_id', $settings_geo->default_country)->get();

                

                // Get cities 

                $cities    = City::where('state_id', $settings_geo->default_state)->get();



            }






        // Phone code

        $phonecode = Country::where('id', $settings_geo->default_country)->select('phonecode')->first();



        // Send data

        $data = array(

            'countries'       => $countries, 

            'detectedCountry' => $detectedCountry, 

            'cities'          => $cities, 

            'states'          => $states, 

            'phonecode'       => $phonecode, 

        );



        // Get Tilte && Description

        $title      = Helper::settings_general()->title;

        $long_desc  = Helper::settings_seo()->description;

        $keywords   = Helper::settings_seo()->keywords;



        // Manage SEO

        SEO::setTitle(__('title.lang_register').' | '.$title);

        SEO::setDescription($long_desc);

        SEO::opengraph()->setUrl(Protocol::home());

        SEOMeta::addKeyword([$keywords]);



        return view($this->theme.'.auth.register')->with($data);

    }



    /*********** Submit Register Request ************/

    public function postRegister(Request $request)

    {



        // Get GEO Settings

        $settings_geo = Helper::settings_geo();



        // Recaptcah rule

        $recaptcha_rule = Helper::settings_security()->recaptcha ? 'required|captcha' : '';



        // Make Validation Rules

        $rules = array(

            'first_name'            => 'required|min:2', 

            'last_name'             => 'required|min:2',

            'username'              => 'required|unique:users',

            'email'                 => 'required|email|unique:users',

            'phone'                 => 'required|numeric|unique:users',

            'phonecode'             => 'required|numeric|exists:countries,phonecode',

            'country'               => 'required|exists:countries,sortname', 

            'state'                 => 'numeric|exists:states,id', 

            'city'                  => 'numeric|exists:cities,id', 

            'gender'                => 'required|boolean',

            'password'              => 'required|min:6|confirmed',

            'password_confirmation' => 'required',

            'terms'                 => 'required',

            'g-recaptcha-response'  => $recaptcha_rule,

        );



        // run the validation rules on the inputs from the form

        $validator = Validator::make(Input::all(), $rules);



        // if the validator fails, redirect back to the form

        if ($validator->fails()) {



            return Redirect::to('auth/register')

                ->withErrors($validator)

                ->withInput(Input::except('password', 'password_confirmation'));



        }else{



            // Get inputs values

            $first_name        = $request->get('first_name');

            $last_name         = $request->get('last_name');

            $username          = $request->get('username');

            $email             = $request->get('email');

            $phone             = $request->get('phone');

            $phonecode         = $request->get('phonecode');

            $gender            = $request->get('gender');

            $country           = $request->get('country');

            $state             = $request->get('state');

            $city              = $request->get('city');

            $full_phone_format = '+'.$phonecode.$phone;



            // Check Spam Email

            if (Spam::email($email)) {



                return Redirect::to('auth/register')->with('error', __('return/error.lang_system_detected_spam_email'))->withInput(Input::except('password', 'password_confirmation'));



            }



            // Check if username on our blacklist

            if (Spam::blacklist_username($username)) {



                return Redirect::to('auth/register')->with('error', __('return/error.lang_username_in_blacklist'))->withInput(Input::except('password', 'password_confirmation'));



            }



            // Check phone number

            try {

        

                if (!PhoneNumber::make($full_phone_format)->isOfCountry($country)) {

                    

                    // Invalid phone format

                    return redirect()->back()->with('error', 'Oops! Invalid phone number format '.$full_phone_format)->withInput(Input::except('password', 'password_confirmation'));



                }



            } catch (\Exception $e) {

                

                // Invalid phone format

                return redirect()->back()->with('error', 'Oops! Invalid phone number format '.$full_phone_format)->withInput(Input::except('password', 'password_confirmation'));



            }



            // register new user

            $user = $this->create($request->all());



            // Check create user response

            if (is_array($user) && array_key_exists('message', $user)) {



                // Error

                return redirect('/auth/register')->with('error', $user['message'])->withInput(Input::except('password', 'password_confirmation'));



            }



            event(new Registered($user));



            // Check if user need activation

            if (Helper::settings_auth()->need_activation) {

                

                // Check if need activation via email

                if (Helper::settings_auth()->activation_type == 'email') {

                    

                    // Generate Activation link

                    $activation_code = Random::activation_code($request->get('email'));



                    // Send Email Activation Key

                    $user->notify(new EmailActivation($activation_code, $request->get('username')));



                    // Save Activation Code in Database

                    DB::table('activations')->insert([

                        'email'      => $request->get('email'),

                        'phone'      => $request->get('phone'),

                        'key'        => $activation_code,

                        'created_at' => Carbon::now(),

                        'updated_at' => Carbon::now()

                    ]);



                    // success Register

                    return Redirect::to('/auth/login')->with('success', __('return/success.lang_account_created_need_active_via_email'));



                }elseif (Helper::settings_auth()->activation_type == 'sms') {

                    

                    // Generate SMS Code

                    $sms_code = Random::sms_code();



                    // Save SMS Code in Database

                    DB::table('activations')->insert([

                        'email'      => $request->get('email'),

                        'phone'      => $request->get('phone'),

                        'key'        => null,

                        'sms_code'   => $sms_code,

                        'created_at' => Carbon::now(),

                        'updated_at' => Carbon::now(),

                    ]);



                    // Send SMS

                    $user->notify(new SMSActivationCode($sms_code));



                    // new session

                    Session::put('phone_number', $request->get('phone'));



                    // Return to active phone

                    return redirect('/auth/activation/phone')->with('success', __('return/success.lang_account_created_need_active_via_sms'));



                }else{



                    // Send Notitifaction to Admins

                    DB::table('notifications_users')->insert([

                        'user_id'    => $user->id,

                        'created_at' => Carbon::now(),

                        'updated_at' => Carbon::now(),

                    ]);



                    // success Register

                    return Redirect::to('/auth/register')->with('success', __('return/success.lang_account_created_need_active_via_dashboard'));



                }



            }else{



                // Auto login after register

                $this->guard()->login($user);



            }



            // success Login

            return Redirect::to('/');





        }





    }





    /************** create new user **************/

    protected function create(array $data)

    {



        // Get GEO Settings

        $settings_geo = Helper::settings_geo();



        // Check if site is international

        if ($settings_geo->is_international) {



            // Get country

            $country  = Country::where('sortname', $data['country'])->first();

            

            // Check if states enabled

            if ($settings_geo->states_enabled) {

                

                // Check if state exists in the selected country

                $check_state = State::where('country_id', $country->id)->first();



                if ($check_state) {

                

                    // Check if cities enabled

                    if ($settings_geo->cities_enabled) {

                        

                        // Check if city exists

                        $check_city = city::where('country_id', $country->id)->first();



                        if (!$check_city) {

                        

                            // City not available in this country

                            $response = array(

                                'status'  => false, 

                                'message' => 'Oops! City not exists in this country.', 

                            );

                            return $response;



                        }



                    }



                }else{



                    // state not available in this country

                    $response = array(

                        'status'  => false, 

                        'message' => 'Oops! State not exists in this country.', 

                    );

                    return $response;



                }



            }elseif ($settings_geo->cities_enabled) {

                

                // check city

                $check_city = City::where('country_id', $country->id)->first();



                if (!$check_city) {

                    

                    // state not available in this country

                    $response = array(

                        'status'  => false, 

                        'message' => 'Oops! City not exists in this country.', 

                    );

                    return $response;



                }



            }



        }else{



            // Get default country

            $country = Country::where('id', $settings_geo->default_country)->first();



            // Check if states enabled

            if ($settings_geo->states_enabled) {

                

                // Check if state exists in the selected country

                $check_state = State::where('country_id', $country->id)->first();



                if ($check_state) {

                

                    // Check if cities enabled

                    if ($settings_geo->cities_enabled) {

                        

                        // Check if city exists

                        $check_city = city::where('state_id', $check_state->id)->first();



                        if (!$check_city) {

                        

                            // City not available in this country

                            $response = array(

                                'status'  => false, 

                                'message' => 'Oops! City not exists in this country.', 

                            );

                            return $response;



                        }



                    }



                }else{



                    // state not available in this country

                    $response = array(

                        'status'  => false, 

                        'message' => 'Oops! State not exists in this country.', 

                    );

                    return $response;



                }



            }elseif ($settings_geo->cities_enabled) {

                

                // check city

                $check_city = City::where('country_id', $country->id)->first();



                if (!$check_city) {

                    

                    // state not available in this country

                    $response = array(

                        'status'  => false, 

                        'message' => 'Oops! City not exists in this country.', 

                    );

                    return $response;



                }



            }



        }



        // Check if user need activation

        if (Helper::settings_auth()->need_activation) {

            $status = 0;

        }else{

            $status = 1;

        }



        // Get geo data to save

        $getState = $settings_geo->states_enabled ? $data['state'] : null;

        $getCity  = $settings_geo->cities_enabled ? $data['city'] : null;



        return User::create([

            'first_name'    => $data['first_name'],

            'last_name'     => $data['last_name'],

            'username'      => $data['username'],

            'email'         => $data['email'],

            'gender'        => $data['gender'],

            'country_code'  => $country->sortname,

            'state'         => $getState,

            'city'          => $getCity,

            'phone'         => $data['phone'],

            'phonecode'     => $data['phonecode'],

            'status'        => $status,

            'last_login_ip' => IP::get(),

            'last_login_at' => Carbon::now(),

            'created_at'    => Carbon::now(),

            'updated_at'    => Carbon::now(),

            'password'      => bcrypt($data['password']),

        ]);

    }





    /************ Auto login after register **************/ 

    protected function guard()

    {

        return Auth::guard();

    }

}

