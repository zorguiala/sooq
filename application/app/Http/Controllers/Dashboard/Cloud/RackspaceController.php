<?php

namespace App\Http\Controllers\Dashboard\Cloud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RackspaceController extends Controller
{
    function __construct()
    {
    	$this->middleware('admin');
    }

    /**
	* Get Rackspace Cloud settings
    */
    public function get()
    {
    	return view('dashboard.clouds.rachspace');
    }

    /**
	* Update Rackspace Cloud Settings
    */
    public function post(Request $request)
    {
    	// Validate Inputs
    	$this->validate([
    		'' => 'required',
    	]);
    }
}
