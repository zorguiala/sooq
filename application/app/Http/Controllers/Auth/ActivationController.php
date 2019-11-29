<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ActivationKeys;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SMSActivationCode;
use Session;
use DB;
use Carbon\Carbon;
use Helper;
use App\User;
use Random;
use Validator;
use Protocol;
use SEO;
use SEOMeta;
use Input;
use Theme;

/**
* ActivationController
*/
class ActivationController extends Controller
{
    public $theme = '';
	
	public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->theme = Theme::get();
    }

	/**
	 * Active Account
	 */
	public function activation(Request $request)
	{
		// Get Activation key
		$key        = $request->get('key');
		
		// Check Key
		$activation = DB::table('activations')->where('key', $key)->first();

		if ($activation) {

			// Check if user active
			if ($activation->activated) {
				// Active
				return redirect('/auth/login')->with('error', __('return/error.lang_account_already_active'));
			}
			
			// Check if expired
			$activation_created = new Carbon($activation->created_at);
			
			$cDate              = Carbon::parse($activation_created);
			
			$expired_minutes    = $cDate->diffInMinutes();
			
			// Get Auth Settings
			$settings_auth      = Helper::settings_auth();

			if ($expired_minutes > $settings_auth->activation_expired_time ) {

				// Expired
				return redirect('/auth/activation/resend')->with('error', __('return/error.lang_activation_expired'));
			}else{

				// Active User
				User::where('email', $activation->email)->update([
					'status' => 1
				]);

				// Mark Activation key as used
				DB::table('activations')->where('key', $key)->update([
					'activated' => 1
				]);

				// Redirect to home
				return redirect('/auth/login')->with('success', __('return/success.lang_account_activated'));

			}

		}else{

			// return 404
			return abort(404);

		}
	}

	/**
	 * Send new Activation Key
	 */
	public function new_key()
	{
		// Check if sms activation gateway enabled
		$settings_auth = Helper::settings_auth();

		if ($settings_auth->activation_type != 'email') {
			return redirect('/')->with('error', __('return/error.lang_feature_disabled'));
		}

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_resend_activation_link').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.auth.activation.resend');
	}

	/**
	 * Resend Activation Key
	 */
	public function resend(Request $request)
	{
		// Check if sms activation gateway enabled
		$settings_auth = Helper::settings_auth();

		if ($settings_auth->activation_type != 'email') {
			return redirect('/')->with('error',  __('return/error.lang_feature_disabled'));
		}

		// Recaptcah rule
        $recaptcha_rule = Helper::settings_security()->recaptcha ? 'required|captcha' : '';

        // validate the info, create rules for the inputs
        $rules = array(
            'email'                => 'required|email',
            'g-recaptcha-response' => $recaptcha_rule,
        );

        // run the validation rules on the inputs
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails
        if ($validator->fails()) {

        	return back()->withErrors($validator)->withInput();

        }else{

			// Get Email Address
			$email = $request->get('email');

			// Check user
			$user  = User::where('email', $email)->where('status', 0)->first();

			if ($user) {
				
				// Generate Activation link
	            $activation_code = Random::activation_code($email);

	            // Send Email
	            Mail::to($email)->send(new ActivationKeys($activation_code));

	            // Save Activation Code in Database
	            DB::table('activations')->insert([
	                'email'      => $email,
	                'key'        => $activation_code,
	                'created_at' => Carbon::now(),
	                'updated_at' => Carbon::now()
	            ]);

	            // Success 
	            return back()->with('success', __('return/success.lang_activation_email_has_sent'));

			}else{

				// Not found
				return back()->with('error', __('return/error.lang_user_not_found'));

			}

		}
	}

	/**
	 * Active from phone
	 */
	public function phone()
	{
		// Check if sms activation gateway enabled
		$settings_auth = Helper::settings_auth();

		if ($settings_auth->activation_type != 'sms') {
			return redirect('/')->with('error', __('return/error.lang_feature_disabled'));
		}

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_active_account').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.auth.activation.phone');
	}

	/**
	 * Verify Phone Number
	 */
	public function phone_verify(Request $request)
	{
		// Check if sms activation gateway enabled
		$settings_auth = Helper::settings_auth();

		if ($settings_auth->activation_type != 'sms') {
			return redirect('/')->with('error', __('return/error.lang_feature_disabled'));
		}

		// Recaptcah rule
        $recaptcha_rule = Helper::settings_security()->recaptcha ? 'required|captcha' : '';

		// Make rules
		$rules = array(
			'phone'                => 'required', 
			'sms_code'             => 'required|numeric',
			'g-recaptcha-response' => $recaptcha_rule, 
		);

		// Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			// Error
			return redirect('/auth/activation/phone')->withErrors($validator)->withInput();
		}else{

			// Get Inputs
			$phone      = $request->get('phone');
			$sms_code   = $request->get('sms_code');
			
			// Check activation
			$activation = DB::table('activations')->where('phone', $phone)->where('sms_code', $sms_code)->where('activated', 0)->first();

			if ($activation) {
				
				// Check if activation code expired
				$activation_created = new Carbon($activation->created_at);
				
				$cDate              = Carbon::parse($activation_created);
				
				$expired_minutes    = $cDate->diffInMinutes();
				
				// Get Auth Settings
				$settings_auth      = Helper::settings_auth();

				if ($expired_minutes > $settings_auth->activation_expired_time ) {

					// Expired
					return redirect('/auth/activation/phone')->with('error', __('return/error.lang_activation_expired'));
				}else{

					// Active User
					User::where('phone', $activation->phone)->update([
						'status' => 1
					]);

					// Mark Activation key as used
					DB::table('activations')->where('phone', $phone)->where('sms_code', $sms_code)->update([
						'activated' => 1
					]);

					// Redirect to home
					return redirect('/auth/login')->with('success', __('return/success.lang_account_activated'));

				}

			}else{
				// Not found
				return redirect('/auth/activation/phone')->with('error', __('return/error.lang_could_not_verify_phone'));
			}

		}
	}

	/**
	 * Resend Phone Activation Code
	 */
	public function phone_resend()
	{
		// Check if sms activation gateway enabled
		$settings_auth = Helper::settings_auth();

		if ($settings_auth->activation_type != 'sms') {
			return redirect('/')->with('error', __('return/error.lang_feature_disabled'));
		}

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_resend_activation_code').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.auth.activation.phone_resend');
	}

	/**
	 * Send Phone Activation Code SMS
	 */
	public function phone_send(Request $request)
	{
		// Check if sms activation gateway enabled
		$settings_auth = Helper::settings_auth();

		if ($settings_auth->activation_type != 'sms') {
			return redirect('/')->with('error', __('return/error.lang_feature_disabled'));
		}

		// Recaptcah rule
        $recaptcha_rule = Helper::settings_security()->recaptcha ? 'required|captcha' : '';

		// Make validation
		$validator = Validator::make($request->all(), [
			'phone'                => 'required',
			'g-recaptcha-response' => $recaptcha_rule,
		]);

		if ($validator->fails()) {
			// Error
			return redirect('/auth/activation/phone/resend')->withErrors($validator)->withInput();
		}else{

			// Get phone number
			$phone = $request->get('phone');

			// Check if phone exists
			$user  = User::where('phone', $phone)->where('status', 0)->first();

			if ($user) {
				
				// Check how many time request new activation code
				$activations = DB::table('activations')->where('phone', $phone)->count();

				if ($activations > 3) {
					return redirect('/auth/activation/phone/resend')->with('error', __('return/error.lang_cannot_request_more_activation_codes'));
				}else{

					// Generate SMS Code
                    $sms_code = Random::sms_code();

                    // Save SMS Code in Database
                    DB::table('activations')->insert([
                        'email'      => $user->email,
                        'phone'      => $phone,
                        'key'        => null,
                        'sms_code'   => $sms_code,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    // Send SMS
                    $user->notify(new SMSActivationCode($sms_code));

                    // new session
                    Session::put('phone_number', $phone);

                    // Return to active phone
                    return redirect('/auth/activation/phone')->with('success', __('return/success.lang_you_will_receive_sms_soon'));

				}

			}else{

				// User not found
				return redirect('/auth/activation/phone/resend')->with('success', __('return/success.lang_you_will_receive_code_if_account_exists'));

			}


		}
	}
}