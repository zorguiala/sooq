<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAccountPayment;
use DB;
use App\User;
use Helper;
use SEOMeta;
use SEO;
use Protocol;
use Theme;

class InterKassaController extends Controller
{
    
	public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Start new payment using Interkassa service
	 * @return string payment page
	 */			
	public function get()
	{
		// Check if gateway is enabled
		if (!Helper::settings_payments()->is_interkassa) {
			
			// Not enabled
			return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

		}

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle('Interkassa | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.checkout.interkassa');
	}

	/**
	 * Progress payment 
	 * @param  Request $request Get request
	 * @return function           Redirect
	 */
	public function post(Request $request)
	{
		
		// Make Rules
		$rules = array(
			'days'        => 'required|numeric'
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {

			// Get inputs values
			$days        = $request->get('days');

			// Days must be between 10 and 5000 days
			if ($days < 7) {
				// Error
				return redirect('checkout/interkassa')->with('error', 'Oops! Days must be greater than 7 days');
			}
			
			// Set Total price
			$total_price = $days * config('interkassa.account_price');

			try {

				include public_path('../vendor/interkassa/interkassa/Shop.php');

				// The following parameters are provided by interkassa
				$shop_id    = config('interkassa.shop_id');
				$secret_key = config('interkassa.secret_key');
				$currency   = config('interkassa.currency');
				
				// Create a shop
				$shop       = \Shop::factory(array(
				    'id'         => $shop_id,
				    'secret_key' => $secret_key
				));

				// Create a payment
				$payment_id     = str_random(16);
				$payment_amount = $total_price;
				$payment_desc   = 'Upgrade your account now';
				
				$payment        = $shop->createPayment(array(
					'id'          => $payment_id,
					'amount'      => $payment_amount,
					'description' => $payment_desc,
					'currency'    => $currency
				));

				$payment->setBaggage('test_baggage');

		        // Get Tilte && Description
		        $title      = Helper::settings_general()->title;
		        $long_desc  = Helper::settings_seo()->description;
		        $keywords   = Helper::settings_seo()->keywords;

		        // Manage SEO
		        SEO::setTitle('Inetrkassa | '.$title);
		        SEO::setDescription($long_desc);
		        SEO::opengraph()->setUrl(Protocol::home());
		        SEOMeta::addKeyword([$keywords]);

				return view($this->theme.'.checkout.interkassa_progress', compact('payment'));
				
			} catch (\Exception $e) {

				// Error
				return redirect('checkout/interkassa')->with('error', $e->getMessage());

			}

		}else{

			// Error
			return redirect('checkout/interkassa')->withErrors($validator);

		}
		
	}


	/**
	 * Get payment status
	 * @return function redirect
	 */
	public function callback(Request $request)
    {

		include public_path('../vendor/interkassa/interkassa/Shop.php');

		// The following parameters are provided by interkassa
		$shop_id    = config('interkassa.shop_id');
		$secret_key = config('interkassa.secret_key');
		$currency   = config('interkassa.currency');
		
		// Create a shop
		$shop       = \Shop::factory(array(
		    'id'         => $shop_id,
		    'secret_key' => $secret_key
		));

		try {

			// Get payment status
			$p_status = $request->get('ik_inv_st');

			// Check if payment was successfully
			if ($p_status == 'success') {
				
				//return print_r($request->all());
				// Success payment
				$status = $shop->receiveStatus($_POST);

			    $payment = $status->getPayment();

			    return print_r( $payment );
				

			}elseif ($p_status == 'canceled') {
				
				// Failed payment
				return redirect('/checkout/interkassa')->with('error', __('return/error.lang_payment_failed'));

			}else{

				// Pending payment
				return redirect('/checkout/interkassa')->with('error', __('return/error.lang_payment_failed'));

			}

		} catch (\Exception $e) {

			// Error
			return redirect('checkout/interkassa')->with('error', $e->getMessage());

		}
    	
		
    } 

}
