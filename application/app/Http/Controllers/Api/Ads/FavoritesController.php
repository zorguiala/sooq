<?php

namespace App\Http\Controllers\Api\Ads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoritesController extends Controller
{
    
    /**
     * Get user favorites ads
     * @return [type] [description]
     */
	public function favorites()
	{
		
		$favorites = auth()->user()->favorites->all();

		return response()->json(['favorites' => $favorites], 200, [], JSON_NUMERIC_CHECK);

	}

}
