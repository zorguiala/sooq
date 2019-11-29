<?php

namespace App\Http\Controllers\Dashboard\Sms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;
use Protocol;

class IdentifyMeController extends Controller
{
    function __construct()
	{
		$this->middleware('admin');
	}

	/**
	* Get IdentifyMe.net Settings
	*/
	public function get()
	{
		// Show nexmo settings page
		return view('dashboard.sms.identifyme');
	}

	/**
	* Update Settings
	*/
	public function post(Request $request)
	{
		// Validate Form
		$request->validate([
			'client_id'     => 'required|numeric',
			'client_secret' => 'required',
		]);

		// Get Inputs values
		$client_id     = $request->get('client_id');
		$client_secret = $request->get('client_secret');

		// Update Settings
		Config::write('identifyme', [
			'clientId'     => $client_id,
			'clientSecret' => $client_secret,
			'callback'     => Protocol::home().'/auth/phone/callback',
		]);

		// Success
		return redirect('/dashboard/settings/sms/identifyme')->with('success', 'Nexmo settings has been successfully updated.');
	}
}
