<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Mail;

/**
* SmtpController
*/
class SmtpController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get smtp settings
	 */
	public function smtp()
	{
		// Get drivers
		$drivers = array(
			'log'      => 'LOG', 
			'sendmail' => 'SENDMAIL', 
			'mail'     => 'MAIL', 
			'smtp'     => 'SMTP', 
		);

		return view('dashboard.settings.smtp')->with('drivers', $drivers);
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array(
			'host'       => 'required', 
			'port'       => 'required|numeric', 
			'username'   => 'required', 
			'password'   => 'required', 
			'email'      => 'required|email', 
			'name'       => 'required', 
			'driver'     => 'required|in:log,smtp,mail,sendmail', 
			'encryption' => 'required|in:tls,ssl', 
		);

		// Run rules 
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			// error
			return back()->withErrors($validator);
		}else{

			// Get inputs
			$host       = $request->get('host');
			$port       = $request->get('port');
			$username   = $request->get('username');
			$password   = $request->get('password');
			$email      = $request->get('email');
			$name       = $request->get('name');
			$driver     = $request->get('driver');
			$encryption = $request->get('encryption');

			// Update Settings
			$config = new \Larapack\ConfigWriter\Repository('mail');

			$config->set('host', $host);
			$config->set('driver', $driver);
			$config->set('encryption', $encryption);
			$config->set('port', $port);
			$config->set('username', $username);
			$config->set('password', $password);
			$config->set('from.address', $email);
			$config->set('from.name', $name);

			$config->save();

			// Success
			return back()->with('success', 'Congratulations! Update has been successfully updated.');

		}
	}

	/**
	* Test MAIL SERVER
	*/
	public function test(Request $request)
	{
		$email = request('email');

		// Send mail
		Mail::raw('test email', function($message) use ($email){

			$message->to($email);
			$message->subject('SMTP SETTINGS WORKING GOOD');

		});

		return 'E-mail sent successfully';

	}

}