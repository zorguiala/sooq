<?php 

namespace App\Http\Controllers\Installation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Config; 
use Session;

/**
* Verify purchase
*/
class VerifyController extends Controller
{
	
	/**
	 * Verify 
	 */
	public function verify()
	{
		// Check if passed verify
		if (Session::get('passed_verify')) {
			
			return redirect('install/database')->with('error', 'Oops! You passed the verify section.');

		}

		return view('install.verify');
	}

	/**
	 * Check purchase code
	 */
	public function check(Request $request)
	{
		// Make rules
		$rules = array( 
			'code'     => 'required', 
			'domain'   => 'required', 
			'username' => 'required', 
			'terms'    => 'required', 
		);

		// Make rules on inputs
		$validator = Validator::make($request->all(), $rules);

		// Check if validation fails
		if ($validator->fails()) {
			
			// Error
			return Redirect::to('install/verify')->withErrors($validator)
										 ->withInput();

		}else{

			// Get inputs
			$code     = $request->get('code');
			$domain   = $request->get('domain');
			$username = $request->get('username');
			
			// Set purchase code
			Config::write('envato', [
				'purchase_code' => $code,
				'domain'        => $domain,
				'username'      => $username
			]);

			// Set Session
			Session::put('passed_verify', true);

			return redirect('install/database')->with('success', 'Your purchase code has been added. Thank you!');

		}
	}

}