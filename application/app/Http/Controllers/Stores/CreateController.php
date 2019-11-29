<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;
use App\Notifications\StoreCreated;
use DB;
use Validator;
use Image;
use Auth;
use Carbon\Carbon;
use Profile;
use Helper;
use App\User;
use Protocol;
use SEO;
use SEOMeta;
use Theme;

/**
 * CreateController
 */

class CreateController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Create New Store 
	 */
	public function create()
	{
		// Get user id
		$user_id = Auth::id();

		// Check if user has store
		$check_store = Store::where('owner_id', $user_id)->first();

		if ($check_store) {
			
			// Check if store active
			if ($check_store->status) {
				
				// Store alive
				return redirect('store/'.$check_store->username);

			}else{

				// Not active
				return redirect('/')->with('error', 'Oops! Your store is not active. Please try again later.');

			}

		}

		// Get User
		$user = User::where('id', $user_id)->first();

		// Check account type
		if ($user->account_type) {
			
			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle(__('title.lang_create_store').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			// Create Store
			return view($this->theme.'.stores.create');

		}else{

			// Upgrade your account
			return redirect('/upgrade')->with('error', __('return/error.lang_upgrade_to_create_store'));

		}
	}

	/**
	 * Insert Store
	 */
	public function insert(Request $request)
	{

		// Get user id
		$user_id = Auth::id();

		// Check if user has store
		$check_store = Store::where('owner_id', $user_id)->first();

		if ($check_store) {
			
			// Check if store active
			if ($check_store->status) {
				
				// Store alive
				return redirect('/store/'.$check_store->username);

			}else{

				// Not active
				return redirect('/')->with('error', 'Oops! Your store is not active. Please try again later.');

			}

		}

		// Get User
		$user = User::where('id', $user_id)->first();

		// Check account type
		if ($user->account_type) {
			
			// Recaptcah rule
        	$recaptcha_rule = Helper::settings_security()->recaptcha ? 'required|captcha' : '';

			// Make Rules 
			$rules = array(
				'username'             => 'required|unique:stores', 
				'title'                => 'required|unique:stores', 
				'short_desc'           => 'required', 
				'long_desc'            => 'required', 
				'category'             => 'required|numeric|exists:categories,id',
				'logo'                 => 'required|image|mimes:jpg,jpeg,png|max:1000',
				'g-recaptcha-response' => $recaptcha_rule, 
			);

			// Run Rules
			$validator = Validator::make($request->all(), $rules);

			if ($validator->passes()) {

				// Get Inputs Values
				$username   = $request->get('username');
				$title      = $request->get('title');
				$short_desc = $request->get('short_desc');
				$long_desc  = $request->get('long_desc');
				$category   = $request->get('category');
				$logo       = $request->file('logo');
				
				// Get Uploads Folder
				$stores_folder = public_path().'/uploads/stores/';
				
				if (!is_dir($stores_folder.$username)) {
					
					// Create New Foler
					$logo_path     = mkdir($stores_folder.$username, 0777);

				}else{

					$logo_path     = $stores_folder.$username;

				}
				
				// Upload Thumbnails
				$logo_up       = Image::make($logo->getRealPath());
				
				// Resize Thumbnails
				$logo_up->resize(200, 200);
				
				// Save Thumbnails
				$logo_up->save(public_path().'/uploads/stores/'.$username.'/logo.png');

				// Logo URL
				$logo_url = Protocol::home().'/application/public/uploads/stores/'.$username.'/logo.png';

				// Check status
				if (Auth::user()->is_admin) {
					$status = 1;
				}else{
					$status = 0;
				}


				$store             = new Store;
				$store->owner_id   = $user_id;
				$store->username   = $username;
				$store->title      = $title;
				$store->short_desc = $short_desc;
				$store->long_desc  = $long_desc;
				$store->category   = $category;
				$store->country    = $user->country_code;
				$store->city       = $user->city;
				$store->state      = $user->state;
				$store->status     = $status;
				$store->logo       = $logo_url;
				$store->ends_at    = $user->store_ends_at;
				$store->created_at = Carbon::now();
				$store->updated_at = Carbon::now();
				$store->save();

				// User has store
				User::where('id', $user_id)->update([
					'has_store' => true
				]);

				// Send notification to admin
				DB::table('notifications_stores')->insert([
					'user_id'        => $user_id,
					'store_username' => $username,
					'created_at'     => Carbon::now(),
				]);

				// Send notification via email to admins
				$admins = User::where('is_admin', 1)->get();

				foreach ($admins as $admin) {
					$admin->notify(new StoreCreated($username));
				}

				if ($status) {
					
					return redirect('/store/'.$username);

				}else{

					return redirect('/')->with('success', __('return/success.lang_store_created'));
				}

			}else{

				// Error
				return back()->withInput()->withErrors($validator);

			}

		}else{

			// Upgrade your account
			return redirect('/upgrade')->with('error', __('return/error.lang_upgrade_to_create_store'));

		}
		
	}

}