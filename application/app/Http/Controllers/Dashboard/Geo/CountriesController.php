<?php

namespace App\Http\Controllers\Dashboard\Geo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Country;
use DB;
use Input;

/**
* CountriesController
*/
class CountriesController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Countries
	 */
	public function countries(Request $request)
	{

		// Check if search a country
		if ($request->get('search')) {
			
			// Get keyword
			$keyword = $request->get('search');

			$countries = Country::where('sortname', 'LIKE', '%' .$keyword. '%')->orWhere('name', 'LIKE', '%' .$keyword. '%')->orderBy('id', 'desc')->paginate(100);

		}else{

			// Display countries by default
			$countries = Country::orderBy('id', 'desc')->paginate(100);

		}

		// Remeber old input
		Input::flash();

		return view('dashboard.geo.countries')->with('countries', $countries);
	}

	/**
	 * Add new country
	 */
	public function add()
	{
		return view('dashboard.geo.add_country');
	}

	/**
	 * Insert Country
	 */
	public function insert(Request $request)
	{
		// Make Rules
		$rules = array(
			'name'      => 'required|unique:countries', 
			'sortname'  => 'required|max:2|unique:countries', 
			'phonecode' => 'required|integer',
		);

		// Validate Form
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return back()->withErrors($validator)->withInput();

		}else{

			// Get Input Values
			$name               = $request->get('name');
			$sortname           = strtoupper($request->get('sortname'));
			$phonecode          = $request->get('phonecode');
			
			$country            = new Country;
			$country->name      = $name;
			$country->sortname  = $sortname;
			$country->phonecode = $phonecode;
			$country->save();

			// Success
			return back()->with('success', 'Country has been successfully added.');

		}
	}

	/**
	 * Edit Country
	 */
	public function edit(Request $request, $id)
	{
		
		// Check country
		$country = Country::where('id', $id)->first();

		if ($country) {
			
			// Edit Country
			return view('dashboard.geo.edit_country')->with('country', $country);

		}else{
			// Not found
			return redirect('/dashboard/geo/countries')->with('error', 'Oops! Country not found.');
		}

	}

	/**
	 * Update Country
	 */
	public function update(Request $request, $id)
	{
		
		// Check country
		$country = Country::where('id', $id)->first();

		if ($country) {
			
			// Make Rules
			$rules = array(
				'name' => [
					'required',
					Rule::unique('countries')->ignore($country->id)
				], 
				'sortname' => [
					'required',
					'max:2',
					Rule::unique('countries')->ignore($country->id)
				], 
				'phonecode' => [
					'required',
					'numeric',
					Rule::unique('countries')->ignore($country->id)
				], 
			);

			// Make Validation
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				
				// error
				return back()->withErrors($validator);

			}else{

				// Update Country
				$country->update([
					'name'      => $request->get('name'),
					'sortname'  => $request->get('sortname'),
					'phonecode' => $request->get('phonecode'),
				]);	

				// success
				return back()->with('success', 'Country has been successfully updated.');

			}

		}else{
			// Not found
			return redirect('/dashboard/geo/countries')->with('error', 'Oops! Country not found.');
		}

	}

	/**
	 * Delete Country
	 */
	public function delete(Request $request, $id)
	{
		
		// Check country
		$country = Country::where('id', $id)->first();

		if ($country) {

			// Can't delete default country
			$settings_geo = DB::table('settings_geo')->where('id', 1)->where('default_country', $id)->first();

			if ($settings_geo) {
				
				// error
				return redirect('/dashboard/geo/countries')->with('error', 'Oops! You cannot delete default country. Please try again.');

			}
			
			// Delete Country
			Country::where('id', $id)->delete();

			// success
			return redirect('/dashboard/geo/countries')->with('success', 'Country has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/geo/countries')->with('error', 'Oops! Country not found.');
		}

	}

}