<?php

namespace App\Http\Controllers\Dashboard\Geo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\State;
use App\Models\Country;
use Validator;
use DB;
use Response;
use Input;

/**
* StatesController
*/
class StatesController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get states
	 */
	public function states(Request $request)
	{
		// Check if search a country
		if ($request->get('search')) {
			
			// Get keyword
			$keyword = $request->get('search');

			$states = State::where('name', 'LIKE', '%' .$keyword. '%')->orderBy('id', 'desc')->paginate(100);

		}else{

			// Display states by default
			$states = State::orderBy('id', 'desc')->paginate(100);

		}

		// Remeber old input
		Input::flash();

		return view('dashboard.geo.states')->with('states', $states);
	}

	/**
	 * Add new state
	 */
	public function add()
	{
		// Get Countries
		$countries = Country::all();

		return view('dashboard.geo.add_state')->with('countries', $countries);
	}

	/**
	 * Insert State
	 */
	public function insert(Request $request)
	{
		// Make Rules
		$rules = array(
			'name'      => 'required|unique:states', 
			'country'   => 'required|numeric|exists:countries,id',
		);

		// Validate Form
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return back()->withErrors($validator)->withInput();

		}else{

			// Get Input Values
			$name       = $request->get('name');
			$country_id = $request->get('country');

			// Insert new state
			$state = new State;
			$state->name = $name;
			$state->country_id = $country_id;
			$state->save();

			// Success
			return back()->with('success', 'State has been successfully added.');

		}
	}

	/**
	 * Edit State
	 */
	public function edit(Request $request, $id)
	{
		// Check state
		$state = State::where('id', $id)->first();

		if ($state) {
			
			// Get Countries
			$countries = Country::all();

			// Edit State
			return view('dashboard.geo.edit_state')->with(['state' => $state, 'countries' => $countries]);

		}else{
			// Not found
			return redirect('/dashboard/geo/states')->with('error', 'Oops! State not found.');
		}
	}

	/**
	 * Update State
	 */
	public function update(Request $request, $id)
	{
		// Check state
		$state = State::where('id', $id)->first();

		if ($state) {
			
			// Make Rules
			$rules = array(
				'name' => [
					'required',
					Rule::unique('states')->ignore($state->id)
				], 
				'country' => [
					'required',
					'exists:countries,id'
				], 
			);

			// Validate
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				// error
				return back()->withErrors($validator);
			}else{

				// Update State
				$state->update([
					'name'       => $request->get('name'),
					'country_id' => $request->get('country'),
				]);

				return back()->with('success', 'State has been successfully updated.');

			}

		}else{
			// Not found
			return redirect('/dashboard/geo/states')->with('error', 'Oops! State not found.');
		}
	}

	/**
	 * Delete State
	 */
	public function delete(Request $request, $id)
	{
		// Check state
		$state = State::where('id', $id)->first();

		if ($state) {

			// Can't delete default state
			$settings_geo = DB::table('settings_geo')->where('id', 1)->where('default_state', $id)->first();

			if ($settings_geo) {
				
				// error
				return redirect('/dashboard/geo/states')->with('error', 'Oops! You cannot delete default state. Please try again.');

			}
			
			// Delete State
			State::where('id', $id)->delete();

			return redirect('/dashboard/geo/states')->with('success', 'State has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/geo/states')->with('error', 'Oops! State not found.');
		}
	}

	/**
	 * States By country
	 */
	public static function states_by_country(Request $request)
	{
		// Check if ajax request
		if ($request->ajax()) {

			// Get Country ID
			$country_id = $request->get('country_id');
			
			// Check country id
			$country = DB::table('countries')->where('id', 
				$country_id)->first();

			if (!$country) {
				// Error
				$response = array(
					'status' => 'error', 
					'msg'    => 'Oops! Country not found.', 
				);
				return Response::json($response);
			}

			// Get states
			$states = DB::table('states')->where('country_id', $country_id)->get();

			// Success
			$response = array(
				'status' => 'success', 
				'data'   => $states, 
			);
			return Response::json($response);

		}
	}

}