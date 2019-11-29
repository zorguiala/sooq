<?php

namespace App\Http\Controllers\Api\Ads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ad;

class ShowController extends Controller
{
    
	public function show($ad_id)
	{
		
		// Check ad
		$ad = Ad::where('ad_id', $ad_id)
		        ->where('status', true)
		        ->where('is_trashed', false)
		        ->first();

		if ($ad) {
			
			// Ad found
			return response()->json(['data' => $ad], 200, [], JSON_NUMERIC_CHECK);

		}else{

			// Make response
			$response = array(
				'status'  => false, 
				'message' => 'Oops! Ad not found.', 
			);

			// Not found
			return response()->json($response, 404, []);

		}

	}

}
