<?php

namespace App\Http\Controllers\Dashboard\Cloud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;

class CloudinaryController extends Controller
{
    function __construct()
    {
    	$this->middleware('admin');
    }

    /**
	* Get Cloudinary Cloud settings
    */
    public function get()
    {
    	return view('dashboard.clouds.cloudinary');
    }

    /**
	* Update Cloudinary Cloud Settings
    */
    public function post(Request $request)
    {
    	// Validate Inputs
    	$request->validate([
			'name'   => 'required',
			'key'    => 'required',
			'secret' => 'required',
    	]);

    	// Get Inputs values
		$cloudName  = $request->get('name');
		$apiKey     = $request->get('key');
		$apiSecret  = $request->get('secret');
		$baseUrl    = "http://res.cloudinary.com/".$cloudName;
		$secureUrl  = "http://res.cloudinary.com/".$cloudName;
		$apiBaseUrl = "https://api.cloudinary.com/v1_1/".$cloudName;

		// Update Settings
		Config::write('cloudder', [
			'cloudName'  => $cloudName,
			'apiKey'     => $apiKey,
			'apiSecret'  => $apiSecret,
			'baseUrl'    => $baseUrl,
			'secureUrl'  => $secureUrl,
			'apiBaseUrl' => $apiBaseUrl,
		]);

		// Successfully Updated
    	return redirect('dashboard/settings/cloud/cloudinary')->with('success', 'Cloudinary has been successfully updated.');
    }
}
