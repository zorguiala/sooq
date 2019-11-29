<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Carbon\Carbon;
use Spam;
use SEO;
use SEOMeta;
use Protocol;
use Helper;
use Purifier;
use Auth;
use Theme;

class ContactController extends Controller
{
    public $theme = '';
    
    function __construct()
    {
        $this->theme = Theme::get();
    }

    /**
     * Contact us
     */
    public function contact()
    {
        // Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_contact_us').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

    	return view($this->theme.'.pages.contact');
    }

    /**
     * Send Msg to Admin or Moderator
     */
    public function send(Request $request)
    {
        // Admin cannot send emails
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect('/')->with('error', __('return/error.lang_cannot_send_yourself_messages'));
        }

    	// Make Rules
    	$rules = array(
			'full_name' => 'required', 
			'email'     => 'required|email', 
			'phone'     => 'phone:AUTO', 
			'subject'   => 'required', 
			'message'   => 'required', 
    	);

    	// Make Rules on inputs
    	$validator = Validator::make($request->all(), $rules);

    	// Check if passes
    	if ($validator->fails()) {
    		
    		// Error
    		return back()->withInput()->withErrors($validator);

    	}else{

    		// Get Inputs values
			$full_name = $request->get('full_name');
			$email     = $request->get('email');
			$phone     = $request->get('phone');
			$message   = Purifier::clean($request->get('message'));
			$subject   = $request->get('subject');

            // Check spam email
            if (Spam::email($email)) {
                return redirect('/contact')->with('error', __('return/error.lang_system_detected_spam_email'));
            }

    		// Send Message to admin
    		DB::table('admin_mailbox')->insert([
				'full_name'  => $full_name,
				'email'      => $email,
				'phone'      => $phone,
				'message'    => $message,
				'subject'    => $subject,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		]);
            
    		// Success
    		return redirect('/contact')->with('success', __('return/success.lang_message_sent'));

    	}
    }

}
