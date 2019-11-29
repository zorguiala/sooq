<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Ad;
use Illuminate\Validation\Rule;
use Validator;
use DB;

/**
* CurrenciesController
*/
class CurrenciesController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Currencies
	 */
	public function currencies()
	{
		// currencies
		$currencies = Currency::orderBy('id', 'desc')->paginate(30);

		return view('dashboard.currencies.currencies')->with('currencies', $currencies);
	}

	/**
	 * Create New Currency
	 */
	public function create()
	{
		// Get countries
		$countries = Country::get();

		return view('dashboard.currencies.create')->with('countries', $countries);
	}

	/**
	 * Insert New Category
	 */
	public function insert(Request $request)
	{
		// Make Rules
		$rules = array(
			'code'      => 'required', 
			'locale'    => 'required', 
			'country'   => 'required|exists:countries,id',
		);

		// Make Rules on Inputs
		$validator = Validator::make($request->all(), $rules);

		// Check if Catch errors
		if ($validator->fails()) {
			
			// Return error catched
			return back()->withErrors($validator)->withInput();

		}else{
			// Get Inputs values
			$code                 = $request->input('code');
			$country              = $request->input('country');
			$locale               = $request->input('locale');

			// Check if currency and locale exist
			if (!array_key_exists($locale, config('locale')) || !array_key_exists($code, config('currency'))) {
				
				// Currency of locale not found
				return redirect('dashboard/currencies/create')->with('error', 'Oops! Selected currency or locale is not available. Please try again.');

			}
			
			// Add new currency
			$currency             = new Currency;
			$currency->code       = $code;
			$currency->locale     = $locale;
			$currency->country_id = $country;
			$currency->save();

			// Success
			return redirect('/dashboard/currencies/create')->with('success', 'Congratulations! Currency has been successfully added.');

		}
	}

	/**
	 * Edit Currency
	 */
	public function edit(Request $request, $code)
	{
		// Check currency code
		$currency = Currency::where('code', $code)->first();

		if ($currency) {
			
			// Get Countries
			$countries = Country::get();

			// Send Data
			$data = array(
				'currency'  => $currency, 
				'countries' => $countries, 
			);

			return view('dashboard.currencies.edit')->with($data);

		}else{
			// Not found
			return redirect('/dashboard/currencies')->with('error', 'Oops! Currency not found.');
		}
	}

	/**
	 * Update Currency
	 */
	public function update(Request $request, $code)
	{

		// Check if currency exists
		$currency = Currency::where('code', $code)->first();

		if (!$currency) {
			
			// Not found
			return redirect('/dashboard/currencies')->with('error', 'Oops! Currency not found.');

		}
		// Make Rules
		$rules = array(
			'code'    => 'required|unique:currencies,code,'.$currency->id,
			'country' => 'required|exists:countries,id',
			'locale'  => 'required',
		);

		// Make Rules on Inputs
		$validator = Validator::make($request->all(), $rules);

		// Check if Catch errors
		if ($validator->fails()) {
			
			// Return error catched
			return back()->withErrors($validator);

		}else{

			// Get Inputs values
			$new_code   = $request->input('code');
			$locale     = $request->input('locale');
			$country_id = $request->input('country');

			// Check if currency and locale exist
			if (!array_key_exists($locale, config('locale')) || !array_key_exists($new_code, config('currency'))) {
				
				// Currency of locale not found
				return back()->with('error', 'Oops! Selected currency or locale is not available. Please try again.');

			}

			// Update Currency
			Currency::where('code', $code)->update([
				'code'       => $new_code,
				'locale'     => $locale,
				'country_id' => $country_id,
			]);

			// Check if this currency set as default
			$geo_settings = DB::table('settings_geo')->where('id', 1)->first();

			if ($code == $geo_settings->default_currency) {
				
				// Update Default currency
				DB::table('settings_geo')->where('id', 1)->update([
					'default_currency' => $new_code
				]);

			}

			// Success
			return redirect('/dashboard/currencies/edit/'.$new_code)->with('success', 'Congratulations! Currency has been successfully updated.');

		}
	}

	/**
	 * Delete Currency
	 */
	public function delete(Request $request, $code)
	{
		// Check currency
		$currency = Currency::where('code', $code)->first();

		if ($currency) {
			
			// Check if other category exists
			$other_currency = Currency::where('code', '!=', $code)->first();

			if (!$other_currency) {
				// Other Currency Not found
				return redirect('/dashboard/currencies')->with('error', 'Oops! There is no other currencies. Please try again.');
			}

			// Update Ads Currency
			Ad::where('currency', $code)->update([
				'currency' => $other_currency->code
			]);

			// Update Default currency
			DB::table('settings_geo')->where('id', 1)->where('default_currency', $code)->update([
				'default_currency' => $other_currency->code,
			]);

			// Delete Currency
			Currency::where('code', $code)->delete();

			// Success
			return redirect('/dashboard/currencies')->with('success', 'Currency has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/currencies')->with('error', 'Oops! Currency not found or is not a sub category.');
		}
	}

}