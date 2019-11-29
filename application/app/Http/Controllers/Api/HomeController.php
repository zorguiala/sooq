<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ad;

class HomeController extends Controller
{
    
	public function index()
	{
		
		// Get ads
		$ads = Ad::orderBy('id', 'desc')->paginate(30);
		return 'Hi';

	}

}
