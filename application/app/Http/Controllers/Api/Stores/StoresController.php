<?php

namespace App\Http\Controllers\Api\Stores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;

class StoresController extends Controller
{
    
    /**
     * Get available stores
     * @return [type] [description]
     */
	public function stores()
	{
		$stores = Store::all();

		return response()->json(['stores', $stores], 200, [], JSON_NUMERIC_CHECK);
	}

	/**
	 * Get a store by username
	 * @param  [type] $username [description]
	 * @return [type]           [description]
	 */
	public function store($username)
	{
		// get store
		$store = Store::where('username', $username)
		              ->where('status', true)
		              ->first();

		if ($store) {
			
			return response()->json(['store' => $store], 200, []);

		}else{

			// Not found
			$response = array(
				'status'  => false, 
				'message' => 'Oops! Store not found.', 
			);

			return response()->json($response, 404, []);

		}
	}

}
