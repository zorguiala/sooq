<?php

namespace App\Http\Controllers\Dashboard\Cloud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoogleController extends Controller
{
    function __construct()
    {
    	$this->middleware('admin');
    }

    /**
	* Get Google Cloud settings
    */
    public function get()
    {
    	return view('dashboard.clouds.google');
    }

    /**
	* Update Google Cloud Settings
    */
    public function post(Request $request)
    {
    	// Validate Inputs
    	$this->validate([
    		'' => 'required',
    	]);
    }
}
