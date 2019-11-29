<?php

namespace App\Http\Controllers\Dashboard\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Store;
use App\Models\Ad;
use App\User;
use App\Notifications\StoreDisabled;
use App\Notifications\StoreReady;
use Validator;
use Uploader;
use Image;
use Protocol;
use Carbon\Carbon;
use DB;

/**
* OptionsController
*/
class OptionsController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Active Store
	 */
	public function active(Request $request, $username)
	{
		// Check Store
		$store = Store::where('username', $username)->where('status', 0)->first();

		if ($store) {
			
			// Active Store
			$store->update([
				'status' => 1
			]);

			// Send User notification
			$user = User::where('id', $store->owner_id)->first();
			$user->notify(new StoreReady());

			// Success
			return redirect('/dashboard/stores')->with('success', 'Store has been successfully activated.');

		}else{
			// Not found
			return redirect('/dashboard/stores')->with('error', 'Oops! Store not found or already active.');
		}
	}

	/**
	 * Inactive Store
	 */
	public function inactive(Request $request, $username)
	{
		// Check Store
		$store = Store::where('username', $username)->where('status', 1)->first();

		if ($store) {
			
			// Inactive Store
			$store->update([
				'status' => 0
			]);

			// Send User notification
			$user = User::where('id', $store->owner_id)->first();
			$user->notify(new StoreDisabled());

			// Success
			return redirect('/dashboard/stores')->with('success', 'Store has been successfully inactivated.');

		}else{
			// Not found
			return redirect('/dashboard/stores')->with('error', 'Oops! Store not found or already active.');
		}
	}

	/**
	 * Store Details
	 */
	public function details(Request $request, $username)
	{
		// Check Store
		$store = Store::where('username', $username)->first();

		if ($store) {

			// Get Ads stats
			$ads_today = Ad::where('user_id', $store->owner_id)->whereDay('created_at', date('d'))->count();
			
			$ads_month = Ad::where('user_id', $store->owner_id)->whereMonth('created_at', date('m'))->count();
			
			$ads_year  = Ad::where('user_id', $store->owner_id)->whereYear('created_at', date('Y'))->count();

			// send data
			$data = array(
				'store'     => $store, 
				'ads_today' => $ads_today, 
				'ads_month' => $ads_month, 
				'ads_year'  => $ads_year, 
			);

			// Store Details
			return view('dashboard.stores.details')->with($data);

		}else{
			// Not found
			return redirect('/dashboard/stores')->with('error', 'Oops! Store not found or already active.');
		}
	}

	/**
	 * delete Store
	 */
	public function delete(Request $request, $username)
	{
		// Check Store
		$store = Store::where('username', $username)->first();

		if ($store) {

			// Delete Store Notifications
			DB::table('notifications_stores')->where('store_username', $username)->delete();

			// Delete Store Feedback
			DB::table('stores_feedback')->where('store', $username)->delete();

			// Delete Store
			Store::where('username', $username)->delete();

			// Success
			return redirect('/dashboard/stores')->with('success', 'Store has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/stores')->with('error', 'Oops! Store not found or already active.');
		}
	}

	/**
	 * Edit Store
	 */
	public function edit(Request $request, $username)
	{
		// Check Store
		$store = Store::where('username', $username)->first();

		if ($store) {

			return view('dashboard.stores.edit')->with('store', $store);

		}else{
			// Not found
			return redirect('/dashboard/stores')->with('error', 'Oops! Store not found or already active.');
		}
	}

	/**
	 * Update Store
	 */
	public function update(Request $request, $username)
	{
		// Check Store
		$store = Store::where('username', $username)->first();

		if ($store) {

			// Make Rules
			$rules = array(
				'title'      => [
					'required',
					'min:3',
					Rule::unique('stores')->ignore($store->id)
				], 
				'username'      => [
					'required',
					'min:3',
					Rule::unique('stores')->ignore($store->id)
				], 
				'short_desc' => 'required', 
				'long_desc'  => 'required', 
				'category'   => 'required|exists:categories,id', 
				'status'     => 'required|boolean', 
				'logo'       => 'image|mimes:png,jpg,jpeg|max:500', 
				'cover'      => 'image|mimes:png,jpg,jpeg|max:2500', 
				'fb_page'    => 'active_url',
				'tw_page'    => 'active_url',
				'go_page'    => 'active_url',
				'yt_page'    => 'active_url',
				'website'    => 'active_url',
			);

			// Make Validation
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				
				// Errors
				return back()->withErrors($validator);

			}else{

				// Get Inputs values
				$title        = $request->get('title');
				$new_username = $request->get('username');
				$short_desc   = $request->get('short_desc');
				$long_desc    = $request->get('long_desc');
				$category     = $request->get('category');
				$status       = $request->get('status');
				$logo         = $request->file('logo');
				$cover        = $request->file('cover');
				$address      = $request->get('address');
				$fb_page      = $request->get('fb_page');
				$tw_page      = $request->get('tw_page');
				$go_page      = $request->get('go_page');
				$yt_page      = $request->get('yt_page');
				$website      = $request->get('website');

				// Update Store
				$store->update([
					'title'      => $title,
					'username'   => $new_username,
					'short_desc' => $short_desc,
					'long_desc'  => $long_desc,
					'category'   => $category,
					'status'     => $status,
					'address'    => $address,
					'fb_page'    => $fb_page,
					'tw_page'    => $tw_page,
					'go_page'    => $go_page,
					'yt_page'    => $yt_page,
					'website'    => $website,
					'updated_at' => Carbon::now(),
				]);

				// Check if request new logo
				if ($logo) {
					
					// Get Logo Path
					$logo_path = public_path().'/uploads/stores/'.$username;

					// Clear Path
					Uploader::deleteFolderFiles($logo_path);
					
					// Upload Logo
					$logo_up       = Image::make($logo->getRealPath());
					
					// Resize Logo
					$logo_up->resize(100, 100);
					
					// Save Logo
					$logo_up->save(public_path().'/uploads/stores/'.$username.'/logo.png');

					// Logo URL
					$logo_url = Protocol::home().'/application/public/uploads/stores/'.$username.'/logo.png';

					// Save Store
					$store->update([
						'logo' => $logo_url
					]);

				}

				// Check if request new cover
				if ($cover) {

					// Make name for cover
					$cover_name = md5(time().uniqid().rand()).'.png';
					
					// Upload Cover
					$cover_up   = Image::make($cover->getRealPath());
					
					// Save Cover
					$cover_up->save(public_path().'/uploads/covers/'.$cover_name);
					
					// Cover URL
					$cover_url  = Protocol::home().'/application/public/uploads/covers/'.$cover_name;

					// Save Store
					$store->update([
						'cover' => $cover_url
					]);

				}

				// Success
				return redirect('/dashboard/stores/edit/'.$new_username)->with('success', 'Store has been successfully updated.');

			}

		}else{
			// Not found
			return redirect('/dashboard/stores')->with('error', 'Oops! Store not found or already active.');
		}
	}

}