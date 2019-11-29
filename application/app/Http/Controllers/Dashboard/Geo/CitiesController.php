<?php

namespace App\Http\Controllers\Dashboard\Geo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Validator;
use DB;
use Input;

/**
* CitiesController
*/
class CitiesController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Cities
	 */
	public function cities(Request $request)
	{
		// Check if search a country
		if ($request->get('search')) {
			
			// Get keyword
			$keyword = $request->get('search');

			$cities = City::where('name', 'LIKE', '%' .$keyword. '%')->orderBy('id', 'desc')->paginate(100);

		}else{

			// Display states by default
			$cities = City::orderBy('id', 'desc')->paginate(100);

		}

		// Remeber old input
		Input::flash();

		return view('dashboard.geo.cities')->with('cities', $cities);
	}

	/**
	 * Add new city
	 */
	public function add()
	{

		// Get Countries
		$countries = Country::all();

		// Send Data
		$data = array(
			'countries' => $countries, 
		);

		return view('dashboard.geo.add_city')->with($data);
	}

	/**
	 * Insert City
	 */
	public function insert(Request $request)
	{

		// Make Rules
		$rules = array(
			'name'    => 'required|unique:cities', 
			'country' => 'required|numeric|exists:countries,id',
			'state'   => 'required|numeric|exists:states,id'
		);

		// Validate Form
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return back()->withErrors($validator)->withInput();

		}else{

			// Get Input Values
			$name             = $request->get('name');
			$country_id       = $request->get('country');
			$state_id         = $request->get('state');

			// Check state and country
			$check = State::where('id', $state_id)->where('country_id', $country_id)->first();

			if (!$check) {
				
				// Error
				return back()->with('error', 'Oops! Something went wrong. Please try again.');

			}
			
			$city             = new City;
			$city->name       = $name;
			$city->state_id   = $state_id;
			$city->save();

			// Success
			return back()->with('success', 'City has been successfully added.');

		}
	}

	/**
	 * Edit City
	 */
	public function edit(Request $request, $id)
	{
		// Check city
		$city = City::where('id', $id)->first();

		if ($city) {
			
			// Get Countries
			$countries = Country::all();

			// Edit City
			return view('dashboard.geo.edit_city')->with(['city' => $city, 'countries' => $countries]);

		}else{
			// Not found
			return redirect('/dashboard/geo/cities')->with('error', 'Oops! City not found.');
		}
	}

	/**
	 * Update City
	 */
	public function update(Request $request, $id)
	{
		// Check city
		$city = City::where('id', $id)->first();

		if ($city) {
			
			// Make Rules
			$rules = array(
				'name'    => [
					'required',
					Rule::unique('cities')->ignore($city->id)
				], 
				'country' => 'required|numeric|exists:countries,id',
				'state'   => 'required|numeric|exists:states,id'
			);

			// Validate Form
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				
				// Error
				return back()->withErrors($validator)->withInput();

			}else{

				// Get Input Values
				$name             = $request->get('name');
				$country_id       = $request->get('country');
				$state_id         = $request->get('state');

				// Check state and country
				$check = State::where('id', $state_id)->where('country_id', $country_id)->first();

				if (!$check) {
					
					// Error
					return back()->with('error', 'Oops! Something went wrong. Please try again.');

				}
				
				$city->update([
					'name'     => $name,
					'state_id' => $state_id,
				]);	

				// Success
				return back()->with('success', 'City has been successfully updated.');

			}

		}else{
			// Not found
			return redirect('/dashboard/geo/cities')->with('error', 'Oops! City not found.');
		}
	}

	/**
	 * Delete City
	 */
	public function delete(Request $request, $id)
	{
		// Check city
		$city = City::where('id', $id)->first();

		if ($city) {

			// Can't delete default state
			$settings_geo = DB::table('settings_geo')->where('id', 1)->where('default_city', $id)->first();

			if ($settings_geo) {
				
				// error
				return redirect('/dashboard/geo/cities')->with('error', 'Oops! You cannot delete default city. Please try again.');

			}
			
			// Delete City
			City::where('id', $id)->delete();

			// Success
			return redirect('dashboard/geo/cities')->with('success', 'City has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/geo/cities')->with('error', 'Oops! City not found.');
		}
	}

}