<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Protocol;
use Helper;
use SEO;
use SEOMeta;
use Theme;

/**
* UpgradeController class
*/
class UpgradeController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}


	/**
	 * Upgrade Account
	 */
	public function upgrade()
	{
		// Get memebership settings
		$settings  = Helper::settings_payments();

		// Get Tilte && Description
		$title     = Helper::settings_general()->title;
		$long_desc = Helper::settings_seo()->description;
		$keywords  = Helper::settings_seo()->keywords;

		// Manage SEO
		SEO::setTitle(__('title.lang_upgrade_account').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home().'/upgrade');
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.account.upgrade', compact('settings'));
	}

	/**
	 * Make Payment
	 */
	public function payment(Request $request)
	{

		// Make Rules
		$rules = array(
			'method'               => 'required|in:paypal,stripe,mollie,paystack,paysafecard,2checkout,razorpay,barion,cashu,pagseguro,paytm,interkassa',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			
			// Error
			return redirect('upgrade')->withErrors($validator);

		}else{

			// Get method
			$method = $request->get('method');

			// Check payment method
			switch ($method) {
				case 'paypal':
					return redirect('checkout/paypal');
					break;
				case 'stripe':
					return redirect('checkout/stripe');
					break;
				case '2checkout':
					return redirect('checkout/2checkout');
					break;
				case 'mollie':
					return redirect('checkout/mollie');
					break;
				case 'paystack':
					return redirect('checkout/paystack');
					break;
				case 'paysafecard':
					return redirect('checkout/paysafecard');
					break;
				case 'razorpay':
					return redirect('checkout/razorpay');
					break;
				case 'barion':
					return redirect('checkout/barion');
					break;
				case 'cashu':
					return redirect('checkout/cashu');
					break;
				case 'pagseguro':
					return redirect('checkout/pagseguro');
					break;
				case 'paytm':
					return redirect('checkout/paytm');
					break;
				case 'interkassa':
					return redirect('checkout/interkassa');
					break;
				
				default:
					return redirect('checkout/paypal');
					break;
			}

		}
		
	}

}