<?php 

namespace App\Http\Controllers\Installation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use Input;
use Hash;
use App\User;
use Carbon\Carbon;
use IP;

/**
* AccountController
*/
class AccountController extends Controller
{
	
	/**
	 * Create Account 
	 */
	public function account()
	{
		// Check if passed account section
		if (Session::get('account_passed')) {
			
			// Already passed
			return redirect('/install/store')->with('error', 'Oops! You passed the account section.');

		}

		return view('install.account');
	}

	/**
	 * Insert admin account
	 */
	public function insert(Request $request)
	{
		
		// Make rules
		$rules = array(
			'fname'    => 'required', 
			'lname'    => 'required', 
			'username' => 'required', 
			'email'    => 'required|email', 
			'password' => 'required|min:6|confirmed',
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('install/account')->withErrors($validator)->withInput(Input::except('password', 'password_confirmation'));

		}else{

			// Get inputs
			$fname    = $request->get('fname');
			$lname    = $request->get('lname');
			$username = $request->get('username');
			$email    = $request->get('email');
			$password = Hash::make($request->get('password'));

			// New user
			$user                = new User;
			$user->username      = $username;
			$user->gender        = 1;
			$user->first_name    = $fname;
			$user->last_name     = $lname;
			$user->email         = $email;
			$user->password      = $password;
			$user->country_code  = 'US';
			$user->state         = 3956;
			$user->city          = 48019;
			$user->account_type  = 1;
			$user->is_admin      = 1;
			$user->status        = 1;
			$user->has_store     = 1;
			$user->store_ends_at = Carbon::now()->addYears(15);
			$user->last_login_ip = IP::get();
			$user->last_login_at = Carbon::now();
			$user->save();

			// Set Session
			Session::put('account_passed', true);

			return redirect('install/store')->with('success', 'Congratulations! Your account has been successfully set.');

		}

	}

	

}