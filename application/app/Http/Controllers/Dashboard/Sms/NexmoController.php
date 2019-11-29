<?php

namespace App\Http\Controllers\Dashboard\Sms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;

class NexmoController extends Controller
{
    function __construct()
	{
		$this->middleware('admin');
	}

	/**
	* Get Nexmo Settings
	*/
	public function get()
	{
		// Show nexmo settings page
		return view('dashboard.sms.nexmo');
	}

	/**
	* Update Settings
	*/
	public function post(Request $request)
	{
		// Validate Form
		$request->validate([
			'nexmo_key'    => 'required',
			'nexmo_secret' => 'required',
			'sms_from'     => 'required',
		]);

		// Get Inputs values
		$key    = $request->get('nexmo_key');
		$secret = $request->get('nexmo_secret');
		$phone  = $request->get('sms_from');

		// Update Settings
		Config::write('services', [
			'nexmo.key'      => $key,
			'nexmo.secret'   => $secret,
			'nexmo.sms_from' => $phone,
		]);

		// Success
		return redirect('/dashboard/settings/sms/nexmo')->with('success', 'Nexmo settings has been successfully updated.');
	}
}
