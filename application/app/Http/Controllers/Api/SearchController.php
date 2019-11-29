<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ad;

class SearchController extends Controller
{
    
	public function search(Request $request)
	{
		
		// Get search keyword
		$q = $request->get('q');

		// Check Keyword
		if (!empty($q)) {

			// Get matched ads
		    $ads = Ad::where('title', 'like', '%' . $q . '%')
		             ->orWhere('description', 'like', '%' . $q . '%')
		             ->where('status', 1)
		             ->where('is_archived', 0)
		             ->where('is_trashed', 0)
		             ->get();
		}else{

			// Get all available ads
			$ads = Ad::where('status', true)
			         ->where('is_trashed', false)
			         ->where('is_archived', false)
			         ->get();

		}

		// Show ads
		return response()->json(['ads', $ads], 200, []);

	}

}
