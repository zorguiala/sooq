<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use Auth;
use IP;
use DB;
use Countries;

class PhoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function callback(Request $request)
    {
    		
		// Read the encrypted report from POST request
		$report = $request->get('report');
		$secret = config('identifyme.clientSecret');

		$postdata = http_build_query(
		    array(
				'report'       => $report,
				'clientSecret' => $secret
		    )
		);

		$opts = [
		    "http" => [
		        "method" => "POST",
		        "header" => "content-type: application/x-www-form-urlencoded\r\n",
		        "content" => $postdata
		    ]
		];
		$context = stream_context_create($opts);
		$response = json_decode(file_get_contents('https://identifyme.net/api/getreport', false, $context));

		$apiResponseObj = new \stdClass;

		//return print_r($response);

		// Successfullly verified
		if($response->isValid){

			// Generate IdentifyMe.net ID
			$phone         = '+'.$response->countryCode.$response->phone;
			$identifyme_id = md5($phone);

			// Check if already verified
			$user = User::where('identifyme_id', $identifyme_id)->first();

			if ($user) {
				
				// Login
				Auth::login($user, true);

				// Success, now redirect to homepage
				return redirect('/');

			}else{

				$faker = new \Faker\Generator();
				$faker->addProvider(new \Faker\Provider\en_US\Person($faker));
				$faker->addProvider(new \Faker\Provider\Internet($faker));

				// Get Geo Settings
        		$geo_settings = DB::table('settings_geo')->where('id', 1)->first();

				// Create new user
				$user = User::create([
					'first_name'    => $faker->firstNameMale,
		            'last_name'     => $faker->lastName,
		            'username'      => strtoupper(str_random(12)),
		            'email'         => $faker->email,
		            'country_code'  => Countries::country_code($geo_settings->default_country),
		            'state'         => $geo_settings->default_state,
		            'city'          => $geo_settings->default_city,
					'gender'        => 1,
					'status'        => 1,
		            'phone'         => $phone,
		            'identifyme_id' => $identifyme_id,
		            'last_login_ip' => IP::get(),
		            'last_login_at' => Carbon::now(),
		            'created_at'    => Carbon::now(),
		            'updated_at'    => Carbon::now()
				]);

				// Login now
				Auth::login($user, true);

				// Success, now redirect to homepage
				return redirect('/');

			}

		}else{
			
			// Failed while verifying phone number
			return redirect('/auth/login')->with('error', 'Oops! We could not verify your phone number. Please try again.');

		}

    }
}
