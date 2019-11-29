<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Razorpay\Api\Api;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAccountPayment;
use Carbon\Carbon;
use App\User;
use DB;
use Auth;
use Validator;
use Session;
use Redirect;
use Theme;
use Helper;
use SEO;
use Protocol;
use SEOMeta;

/**
* RazorPay controller 
**/

class RazorpayController extends Controller
{    

	public $theme = '';

    public function __construct()
    {
		$this->middleware('auth');
        $this->theme = Theme::get();
    }


    public function get()
    {        
    	// Check if gateway is enabled
		if (!Helper::settings_payments()->is_razorpay) {
			
			// Not enabled
			return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

		}

		// Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('update_three.lang_razorpay_checkout').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.checkout.razorpay');
    }

    public function post(Request $request)
    {
        // Make rules
        $rules = array(
            'days' => 'required|numeric', 
        );

        // Make validation
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            
            // Return to RazorPay Gateway
            return redirect(Protocol::home().'/checkout/razorpay/progress?days='.$request->get('days'));

        }else{

            // Error
            return redirect('/checkout/razorpay')->withErrors($validator);

        }
    }

    /**
    * Pregress Payment
    */
    public function progress(Request $request)
    {
        // Get days
        $days = $request->get('days');

        // Check days
        if (is_numeric($days)) {

            // Generate Amount
            $amount = (config('razorpay.account_price') * $days) * 100;
            
            // Get data
            $data = array(
                'amount' => $amount, 
                'days'   => $days, 
            );

            // Progress payment
            return view($this->theme.'.checkout.razorpay_progress')->with($data);

        }else{

            // Invalid days numbers
            return redirect('/checkout/razorpay')->with('error', 'Oops! Invalid days format.');

        }
    }

    /**
    * Checkout
    */
    public function checkout(Request $request)
    {
        //Input items of form
        $input   = Input::all();
        
        //get API Configuration 
        $api     = new Api(config('razorpay.razor_key'), config('razorpay.razor_secret'));

        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {

            // Handle new payment
            try {

                $response                     = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));

                // Get total amount
                $total_price                  = $response->amount / 100;
                
                // Get days
                $days                         = $total_price / config('razorpay.account_price');
                
                // Get currency
                $currency                     = $response->currency;
                
                // Set Expire Date
                $ends_at                      = Carbon::now()->addDays($days);
                
                // Payment Success, Create new Subscription
                $subscription                 = new Subscription;
                $subscription->user_id        = Auth::id();
                $subscription->days           = $days;
                $subscription->brand          = 'razorpay';
                $subscription->transaction_id = $response->id;
                $subscription->card_number    = null;
                $subscription->exp_year       = null;
                $subscription->exp_month      = null;
                $subscription->cvv            = null;
                $subscription->card_last_four = null;
                $subscription->amount         = $total_price;
                $subscription->currency       = $currency;
                $subscription->is_accepted    = NULL;
                $subscription->ends_at        = $ends_at;
                $subscription->save();

                // Send Admin Notification
                $admin = User::where('is_admin', 1)->where('id', 1)->first();
                $admin->notify(new NewAccountPayment([
                    'user_id'        => Auth::id(),     
                    'method'         => 'razorpay',       
                    'type'           => 'account',      
                    'transaction_id' => $response->id,     
                    'user_id'        => Auth::id()
                ]));

                // Add Payment Notification to databse
                DB::table('notifications_payments')->insert([
                    'user_id'          => Auth::id(),
                    'payment_id'       => $subscription->id,
                    'transaction_id'   => $response->id,
                    'payment_method'   => 'razorpay',
                    'payment_type'     => 'account',
                    'payment_amount'   => $total_price,
                    'payment_currency' => $currency,
                    'created_at'       => Carbon::now(),
                    'updated_at'       => Carbon::now(),
                ]);

                // Return Success
                return redirect('checkout/razorpay')->with('success', __('return/success.lang_payment_success'));

                

            } catch (\Exception $e) {
                
                // Error
                return redirect('checkout/razorpay')->with('error', $e->getMessage());

            }
        }
    }
}