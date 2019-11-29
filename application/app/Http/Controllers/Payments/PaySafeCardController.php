<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Protocol;
use Redirect;
use App\User;
use Session;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAccountPayment;
use DB;
use IP;
use App\Library\PaySafeCardSDK\PaysafecardPaymentController;
use Helper;
use SEOMeta;
use SEO;
use Theme;

/**
 * PaySafeCardController
 */

class PaySafeCardController extends Controller
{
    public $theme = '';
    
    function __construct()
    {
        $this->middleware('auth');
        $this->theme = Theme::get();
    }

    /**
     * Pay with paysafecard
     */
    public function get()
    {
        // Check if gateway is enabled
        if (!Helper::settings_payments()->is_paysafecard) {
            
            // Not enabled
            return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

        }

        // Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('update.lang_paysafecard_checkout').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

        return view($this->theme.'.checkout.psc');
    }

    public function post(Request $request)
    {
        // Make validation
        $validator = Validator::make($request->all(), [
            'days' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            
            // Error
            return redirect('checkout/paysafecard')->withErrors($validator);

        }

        // Get Days
        $days = $request->get('days');

        // Put days in session
        Session::put('account_upgrade_days', $days);

        // Days must be between 10 and 5000 days
        if ($days < 10) {
            // Error
            return redirect('checkout/paysafecard')->with('error', 'Oops! Days must be greater than 10 days');
        }

        // Set total price
        $total_price  = $days * config('paysafecard.account_price');

        try {
            
            // Get Paysafecard Config
            $psc_key          = config('paysafecard.psc_key');
            $environment      = config('paysafecard.environment');
            $currency         = config('paysafecard.currency');
            
            // Set Payment Details
            $amount           = $total_price;
            $customer_id      = md5(time());
            $customer_ip      = IP::get();
            $success_url      = Protocol::home().'/checkout/paysafecard/success';
            $failure_url      = Protocol::home().'/checkout/paysafecard/failed';
            $notification_url = Protocol::home().'/checkout/paysafecard/notification';
            $correlation_id   = "corrID_" . uniqid();
            
            // create new Payment Controller
            $pscpayment       = new PaysafecardPaymentController($psc_key, $environment);
            
            // creating a payment and receive the response
            $response         = $pscpayment->createPayment($amount, $currency, $customer_id, $customer_ip, $success_url, $failure_url, $notification_url, $correlation_id);

                // response handling
                if ($response == false) {
                    $error = $pscpayment->getError();

                    return redirect('checkout/paysafecard')->with('error', 'Oops! '.$error["message"]);

                } else if (isset($response["object"])) {

                    if (isset($response["redirect"])) {
                        
                        return redirect($response["redirect"]['auth_url']);

                    }

                }
            
            
        } catch (\Exception $e) {
            
            // Error
            return redirect('checkout/paysafecard')->with('error', 'Oops! '.$e->getMessage());

        }
    }

    public function failed()
    {
        // Payment Failed
        return redirect('checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));
    }

    public function success(Request $request)
    {

        // Get Paysafecard Config
        $psc_key     = config('paysafecard.psc_key');
        $environment = config('paysafecard.environment');
        $currency    = config('paysafecard.currency');
        
        // create new Payment Controller
        $pscpayment  = new PaysafecardPaymentController($psc_key, $environment);

        // checking for actual action
        if ($request->get('payment_id')) {

            $id       = $request->get('payment_id');
            
            // get the current payment information
            $response = $pscpayment->retrievePayment($id);

            if (!$response) {

                // retrieving the payment failed
                return redirect('checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));

            }elseif (isset($response["object"])) {

                if ($response["status"] == "SUCCESS") {

                    // transaction was successful
                    $amount                       = $response['amount'];
                    
                    // Check days
                    $days                         = Session::get('account_upgrade_days');
                    
                    // Set Expire date
                    $ends_at                      = Carbon::now()->addDays($days);
                    
                    // Payment ID
                    $payment_id                   = $response['id'];
                    
                    // Payment Success, Create new Subscription
                    $subscription                 = new Subscription;
                    $subscription->user_id        = Auth::id();
                    $subscription->days           = $days;
                    $subscription->brand          = 'paysafecard';
                    $subscription->transaction_id = $payment_id;
                    $subscription->card_number    = NULL;
                    $subscription->exp_year       = NULL;
                    $subscription->exp_month      = NULL;
                    $subscription->cvv            = NULL;
                    $subscription->card_last_four = NULL;
                    $subscription->amount         = $amount / 1000;
                    $subscription->currency       = config('paysafecard.currency');
                    $subscription->is_accepted    = NULL;
                    $subscription->ends_at        = $ends_at;
                    $subscription->save();

                    // Send Admin Notification
                    $admin = User::where('is_admin', 1)->where('id', 1)->first();

                    $admin->notify(new NewAccountPayment([
                        'user_id'        => Auth::id(),
                        'method'         => 'paysafecard',       
                        'type'           => 'account',      
                        'transaction_id' => $payment_id,        
                        'user_id'        => Auth::id()
                    ]));

                    // Add Payment Notification to databse
                    DB::table('notifications_payments')->insert([
                        'user_id'          => Auth::id(),
                        'payment_id'       => $subscription->id,
                        'transaction_id'   => $payment_id,
                        'payment_method'   => 'paysafecard',
                        'payment_type'     => 'account',
                        'payment_amount'   => $amount / 1000,
                        'payment_currency' => config('paysafecard.currency'),
                        'created_at'       => Carbon::now(),
                        'updated_at'       => Carbon::now(),
                    ]);

                    // Delete Session values
                    Session::forget('account_upgrade_days');

                    // Thank the user for the upgrade
                    return redirect('/checkout/paysafecard')->with('success', __('return/success.lang_payment_success'));

                }else{

                    // retrieving the payment failed
                    return redirect('checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));

                }

            }else{

                // Payment Failed
                return redirect('checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));

            }
        }else{

            // Payment Failed
            return redirect('checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));

        }
        
    }

}