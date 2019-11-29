<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Firewall\Vendor\Laravel\Models\Firewall;
use Validator;
use Tracker;
use App\Models\Country;
use DB;

/**
* FirewallController
*/
class FirewallController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Blockec List
	 */
	public function firewall()
	{
		// Get list
		$firewall = Firewall::orderBy('id', 'desc')->paginate(30);

		return view('dashboard.firewall.firewall')->with('firewall', $firewall);
	}

	/**
	 * Add IP
	 */
	public function add()
	{
		return view('dashboard.firewall.add');
	}

	/**
	 * Insert IP
	 */
	public function insert(Request $request)
	{
		// Make Validation
		$validator = Validator::make($request->all(), [
			'ip_address' => 'required|ip|unique:firewall'
		]);

		if ($validator->fails()) {
			
			// Error
			return back()->withErrors($validator)->withInput();

		}else{

			// Get IP Address
			$ip                     = $request->get('ip_address');
			
			// Insert IP
			$firewall               = new Firewall;
			$firewall->ip_address   = $ip;
			$firewall->save();

			return redirect('/dashboard/firewall/add')->with('success', 'IP Address has been successfully added to blacklist.');

		}
	}

	/**
	 * Delete IP From List
	 */
	public function delete(Request $request, $ip)
	{
		// check ip
		$ip_address = Firewall::where('ip_address', $ip)->first();

		if ($ip) {
			
			// delete
			$ip_address->delete();

			// Success
			return redirect('/dashboard/firewall')->with('success', 'IP Address has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/firewall')->with('error', 'Oops! IP Address not found.');
		}
	}

	/**
	 * Failed Login History
	 */
	public function failed_login()
	{
		// Get failed login history
		$failed_login = DB::table('failed_login')->orderBy('id', 'desc')->paginate(30);

		return view('dashboard.firewall.failed_login')->with('failed_login', $failed_login);
	}

	/**
	 * Clear Login History
	 */
	public function login_history_clear()
	{
		// Clear
		DB::table('failed_login')->truncate();

		return redirect('/dashboard/login/history')->with('success', 'Login history has been successfully cleared.');
	}

}