<?php 

namespace App\Http\Controllers\Installation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use Protocol;
use Image;
use App\Models\Store;
use Carbon\Carbon;

/**
* StoreController
*/
class StoreController extends Controller
{
	
	/**
	 * Create store
	 */
	public function store()
	{
		// Check if passed database section
		if (Session::get('store_passed')) {
			
			// Already passed
			return redirect('/install/finish')->with('error', 'Oops! You passed the store section.');

		}

		return view('install.store');
	}

	/**
	 * Insert Store
	 */
	public function insert(Request $request)
	{
		// Make rules
		$rules = array(
			'username' => 'required', 
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('install/store')->withErrors($validator)->withInput();

		}else{

			// Get inputs
			$username          = $request->get('username');
			$title             = $request->get('title');
			$short_desc        = $request->get('short_desc');
			$logo              = public_path('installer/store-logo.png');
			
			// Upload store logo
			$stores_folder     = public_path().'/uploads/stores/';
			
			if (is_dir($stores_folder.$username)) {
				
				// Existsing path
				$logo_path         = $stores_folder.$username;

			}else{

				// Create New Foler
				$logo_path         = mkdir($stores_folder.$username, 0777);

			}
			
			
			// Upload Thumbnails
			$logo_up           = Image::make($logo);
			
			// Resize Thumbnails
			$logo_up->resize(200, 200);
			
			// Save Thumbnails
			$logo_up->save(public_path().'/uploads/stores/'.$username.'/logo.png');
			
			// Logo URL
			$logo_url          = Protocol::home().'/application/public/uploads/stores/'.$username.'/logo.png';
			
			// Create new store
			$store             = new Store;
			$store->owner_id   = 1;
			$store->username   = $username;
			$store->title      = $title;
			$store->short_desc = $short_desc;
			$store->category   = 2;
			$store->logo       = $logo_url;
			$store->country    = 'US';
			$store->state      = 3956;
			$store->city       = 48019;
			$store->status     = 1;
			$store->ends_at    = Carbon::now()->addYears(15);
			$store->save();

			// Set Session
			Session::put('store_passed', true);

			// Success
			return redirect('install/finish')->with('success', 'Congratulations! Your store has been successfully set.');

		}
	}

	

}