<?php

namespace App\Http\Controllers\Dashboard\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

/**
* StoresController
*/
class StoresController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Stores
	 */
	public function stores()
	{
		// Stores
		$stores = Store::orderBy('id', 'desc')->paginate(30);

		return view('dashboard.stores.stores')->with('stores', $stores);
	}

}