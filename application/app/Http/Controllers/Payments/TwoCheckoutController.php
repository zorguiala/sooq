<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Twocheckout;
use Twocheckout_Charge;
use Twocheckout_Error;
use Protocol;
use Redirect;
use App\User;
use Session;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAccountPayment;
use DB;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Helper;
use SEOMeta;
use SEO;
use Theme;

/**
 * TwoCheckoutController
 */

class TwoCheckoutController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Pay with 2checkout
	 */
	public function get()
	{
		// Check if gateway is enabled
		if (!Helper::settings_payments()->is_2checkout) {
			
			// Not enabled
			return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

		}

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('update.lang_2checkout_checkout').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.checkout.2checkout');
	}

	public function post(Request $request)
	{
		// Make Rules
		$rules = array(
			'days'        => 'required|numeric', 
			'number'      => 'required|numeric', 
			'expiryYear'  => 'required|numeric', 
			'expiryMonth' => 'required|numeric', 
			'cvv'         => 'required|numeric',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {
			
			// Get Default Payment Currency
			$currency      = config('services.2checkout.currency');
			
			// Get Inputs
			$days          = $request->get('days');
			$number        = $request->get('number');
			$expiryYear    = $request->get('expiryYear');
			$expiryMonth   = $request->get('expiryMonth');
			$cvv           = $request->get('cvv');
			$token         = $request->get('token');

			// Days must be between 10 and 5000 days
			if ($days < 10) {
				// Error
				return redirect('checkout/2checkout')->with('error', 'Oops! Days must be greater than 10 days');
			}
			
			// Get 2checkout Seller ID
			$seller_id     = config('services.2checkout.seller_id');
			
			// Get 2Checkout keys
			$private_key   = config('services.2checkout.private_key');
			
			// Get user details
			$user_email    = Auth::user()->email;
			$user_phone    = Auth::user()->phone;
			$user_city     = City::where('id', Auth::user()->city)->first();
			$user_state    = State::where('id', Auth::user()->state)->first();
			$user_country  = Country::where('sortname', Auth::user()->country_code)->first();
			$user_fullname = Auth::user()->first_name.' '.Auth::user()->last_name; 

			// Set total price
			$total_price   = $days * config('services.2checkout.account_price');

			// Config 2Checkout Settings
			Twocheckout::privateKey($private_key);
			Twocheckout::sellerId($seller_id);
			Twocheckout::sandbox(false);

			// Progress Payment
			try {

			    $charge = Twocheckout_Charge::auth(
			        array(
						"sellerId"        => $seller_id, 
						"merchantOrderId" => uniqid(), 
						"token"           => $token, 
						"currency"        => $currency, 
						"total"           => $total_price, 
						"billingAddr"     => array(
								"name"        => $user_fullname, 
								"addrLine1"   => $user_city->name.' '.$user_state->name.' '.$user_country->name, 
								"city"        => $user_city->name, 
								"state"       => $user_state->name, 
								"zipCode"     => '43123', 
								"country"     => $user_country->name, 
								"email"       => $user_email, 
								"phoneNumber" => $user_phone
		                ), 
		                "shippingAddr"    => array(
		                    	"name"        => $user_fullname, 
								"addrLine1"   => $user_city->name.' '.$user_state->name.' '.$user_country->name, 
								"city"        => $user_city->name, 
								"state"       => $user_state->name, 
								"zipCode"     => '43123', 
								"country"     => $user_country->name, 
								"email"       => $user_email, 
								"phoneNumber" => $user_phone
		                )
		            )
		        );

			    if ($charge['response']['responseCode'] == 'APPROVED') {

			    	// Get Subscription option
					$card_last_four = Helper::credit_last_four($number);
					$brand          = Helper::detectCardBrand($number);

					// Set Expire Date
					$ends_at = Carbon::now()->addDays($days);

			    	// Payment Success, Create new Subscription
					$subscription                 = new Subscription;
					$subscription->user_id        = Auth::id();
					$subscription->days           = $days;
					$subscription->brand          = $brand;
					$subscription->transaction_id = $charge['response']['transactionId'];
					$subscription->card_number    = $number;
					$subscription->exp_year       = $expiryYear;
					$subscription->exp_month      = $expiryMonth;
					$subscription->cvv            = $cvv;
					$subscription->card_last_four = $card_last_four;
					$subscription->amount         = $total_price;
					$subscription->currency       = $currency;
					$subscription->is_accepted    = NULL;
					$subscription->ends_at        = $ends_at;
			    	$subscription->save();

			    	// Send Admin Notification
					$admin = User::where('is_admin', 1)->where('id', 1)->first();
					$admin->notify(new NewAccountPayment([
						'user_id'        => Auth::id(),		
						'method'         => '2checkout',		
						'type'           => 'account',		
						'transaction_id' => $charge['response']['transactionId'],		
						'user_id'        => Auth::id()
					]));

					// Add Payment Notification to databse
					DB::table('notifications_payments')->insert([
						'user_id'          => Auth::id(),
						'payment_id'       => $subscription->id,
						'transaction_id'   => $charge['response']['transactionId'],
						'payment_method'   => '2checkout',
						'payment_type'     => 'account',
						'payment_amount'   => $total_price,
						'payment_currency' => $currency,
						'created_at'       => Carbon::now(),
						'updated_at'       => Carbon::now(),
					]);

			    	// Return Success
			    	return redirect('checkout/2checkout')->with('success', __('return/success.lang_payment_success'));
			        
			    }
			} catch (Twocheckout_Error $e) {
				// Error Happened
			    return redirect('checkout/2checkout')->with('error', 'Oops! '.$e->getMessage());
			}

		}else{

			// Error
			return redirect('checkout/2checkout')->withErrors($validator);

		}
	}

}