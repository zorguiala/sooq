<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PagesController extends Controller
{
    
    /**
     * Show a custom page
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
	public function page($slug)
	{
		// Check page
		$page = DB::table('pages')->where('page_slug', $slug)->first();

		if ($page) {
			
			// Show page
			return response()->json(['page' => $page], 200, []);

		}else{

			// Not found
			$response = array(
				'status'  => false, 
				'message' => 'Oops! Page not found.', 
			);

			return response()->json($response, 404, []);

		}
	}

}
