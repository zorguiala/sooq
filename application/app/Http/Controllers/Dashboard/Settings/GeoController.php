<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Currency;
use Helper;
use Config;

/**
* GeoController
*/
class GeoController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Edit App Geo Settings
	 */
	public function edit()
	{
		// Get Settings
		$settings   = DB::table('settings_geo')->where('id', 1)->first();
		
		// Get Countries
		$countries  = Country::get();
		
		// Get States
		$states     = State::where('country_id', $settings->default_country)->get();
		
		// Get cities
		$cities     = City::where('state_id', $settings->default_state)->get();
		
		// Get Currencies
		$currencies = config('currency');

		// Get Locales
		$locales    = config('locale');
		
		// Send data
		$data       = array(
			'settings'   => $settings, 
			'countries'  => $countries, 
			'states'     => $states, 
			'cities'     => $cities, 
			'currencies' => $currencies, 
			'locales'    => $locales, 
		);

		return view('dashboard.settings.geo')->with($data);
	}

	/**
	 * Update Settings
	 */
	public function update(Request $request)
	{
		// Make Rules
		$rules = array(
			'is_international'    => 'required|boolean', 
			'states_enabled'      => 'required|boolean', 
			'cities_enabled'      => 'required|boolean', 
			'default_country'     => 'required|numeric|exists:countries,id', 
			'default_state'       => 'required|numeric|exists:states,id', 
			'default_city'        => 'required|numeric|exists:cities,id', 
			'default_currency'    => 'required', 
			'default_locale'      => 'required', 
			'google_maps_key'     => 'required', 
			'trim_trailing_zeros' => 'required|boolean', 
		);

		// Run rules on requested inputs
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {
			
			// Get Inputs values
			$is_international    = $request->get('is_international');
			$default_country     = $request->get('default_country');
			$default_state       = $request->get('default_state');
			$default_city        = $request->get('default_city');
			$default_currency    = $request->get('default_currency');
			$default_locale      = $request->get('default_locale');
			$states_enabled      = $request->get('states_enabled');
			$cities_enabled      = $request->get('cities_enabled');
			$key                 = $request->get('google_maps_key');
			$trim_trailing_zeros = $request->get('trim_trailing_zeros');
			$latitude            = $request->get('latitude');
			$longitude           = $request->get('longitude');

			// Check trim trailing zeros
			if ($trim_trailing_zeros == 1) {
				$trim_trailing_zeros = true;
			}else{
				$trim_trailing_zeros = false;
			}

			// Check if currency and locale exist
			if (!array_key_exists($default_locale, config('locale')) || !array_key_exists($default_currency, config('currency'))) {
				
				// Currency of locale not found
				return redirect('dashboard/settings/geo')->with('error', 'Oops! Selected currency of locale is not available. Please try again.');

			}

			// Check if country, state, city are correct
			$state = State::where('id', $default_state)->where('country_id', $default_country)->first();

			if ($state) {
				
				// Check city
				$city = City::where('id', $default_city)->where('state_id', $default_state)->first();

				if (!$city) {
					
					// City not found
					return redirect('dashboard/settings/geo')->with('error', 'Oops! City not found in this state.');

				}	

			}else{

				// State not found
				return redirect('dashboard/settings/geo')->with('error', 'Oops! State not found in this country.');

			}

			// Update Settings
			DB::table('settings_geo')->where('id', 1)->update([
				'is_international' => $is_international,
				'default_country'  => $default_country,
				'default_state'    => $default_state,
				'default_city'     => $default_city,
				'default_currency' => $default_currency,
				'default_locale'   => $default_locale,
				'states_enabled'   => $states_enabled,
				'cities_enabled'   => $cities_enabled,
			]);

			// Update settings
			Config::write('settings', [
				'default_currency'    => $default_currency,
				'default_locale'      => $default_locale,
				'default_latitude'    => $latitude,
				'default_longitude'   => $longitude,
				'trim_trailing_zeros' => $trim_trailing_zeros,
			]);

			// Update settings
			Config::write('google-maps', [
				'key'              => $key
			]);

			// success
			return back()->with('success', 'Congratulations! Settings has been successfully updated.');

		}else{

			// Error Happend
			return back()->withErrors($validator);

		}
	}

}