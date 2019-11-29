<?php

namespace App\Http\Controllers\Ads\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Protocol;
use Redirect;
use App\User;
use Session;
use App\Models\Ad;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAdPayment;
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
    public function get(Request $request, $ad_id)
    {

        // Get user id
        $user_id = Auth::id();
        
        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if ($ad) {

            // Check if gateway is enabled
            if (!Helper::settings_payments()->is_paysafecard) {
                
                // Not enabled
                return redirect('account/ads/upgrade/'.$ad_id)->with('error', __('update.lang_gateway_not_enabled'));

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

            return view($this->theme.'.account.ads.checkout.paysafecard', compact('ad'));

        }else{
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
        }
    }

    public function post(Request $request, $ad_id)
    {
        // Get user id
        $user_id = Auth::id();
        
        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if ($ad) {

            // Make validation
            $validator = Validator::make($request->all(), [
                'days' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                
                // Error
                return redirect('account/ads/'.$ad_id.'/checkout/paysafecard')->withErrors($validator);

            }

            // Get Days
            $days = $request->get('days');

            // Put days in session
            Session::put('ad_upgrade_days', $days);

            // Days must be at less week
            if ($days < 7) {
                // Error
                return redirect('account/ads/'.$ad_id.'/checkout/paysafecard')->with('error', 'Oops! Days must be greater than week');
            }

            // Set total price
            $total_price  = $days * config('paysafecard.ad_price');

            try {
                
                // Get Paysafecard Config
                $psc_key          = config('paysafecard.psc_key');
                $environment      = config('paysafecard.environment');
                $currency         = config('paysafecard.currency');
                
                // Set Payment Details
                $amount           = $total_price;
                $customer_id      = md5(time());
                $customer_ip      = IP::get();
                $success_url      = Protocol::home().'/account/ads/'.$ad_id.'/checkout/paysafecard/success';
                $failure_url      = Protocol::home().'/account/ads/'.$ad_id.'/checkout/paysafecard/success';
                $notification_url = Protocol::home().'/account/ads/'.$ad_id.'/checkout/paysafecard/success';
                $correlation_id   = "corrID_" . uniqid();
                
                // create new Payment Controller
                $pscpayment       = new PaysafecardPaymentController($psc_key, $environment);
                
                // creating a payment and receive the response
                $response         = $pscpayment->createPayment($amount, $currency, $customer_id, $customer_ip, $success_url, $failure_url, $notification_url, $correlation_id);

                    // response handling
                    if ($response == false) {
                        $error = $pscpayment->getError();

                        return redirect('/account/ads/'.$ad_id.'/checkout/paysafecard')->with('error', 'Oops! '.$error["message"]);

                    } else if (isset($response["object"])) {

                        if (isset($response["redirect"])) {
                            
                            return redirect($response["redirect"]['auth_url']);

                        }

                    }
                
                
            } catch (\Exception $e) {
                
                // Error
                return redirect('/account/ads/'.$ad_id.'/checkout/paysafecard')->with('error', 'Oops! '.$e->getMessage());

            }

        }else{
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
        }
    }

    public function failed(Request $request, $ad_id)
    {
        // Payment Failed
        return redirect('/account/ads/'.$ad_id.'/checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));
    }

    public function success(Request $request, $ad_id)
    {
        // Get user id
        $user_id = Auth::id();
        
        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if ($ad) {

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
                    return redirect('/account/ads/'.$ad_id.'/checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));

                }elseif (isset($response["object"])) {

                    if ($response["status"] == "SUCCESS") {

                        // transaction was successful
                        $amount                       = $response['amount'];
                        
                        // Check days
                        $days                         = Session::get('ad_upgrade_days');
                        
                        // Set Expire date
                        $ends_at                      = Carbon::now()->addDays($days);
                        
                        // Payment ID
                        $payment_id                   = $response['id'];

                        // Payment Success, Create new ad payment
                        $setPayment = DB::table('ads_payments')->insertGetId([
                            'user_id'        => Auth::id(),
                            'ad_id'          => $ad_id,
                            'days'           => $days,
                            'brand'          => 'paysafecard',
                            'transaction_id' => $payment_id,
                            'card_number'    => NULL,
                            'exp_year'       => NULL,
                            'exp_month'      => NULL,
                            'cvv'            => NULL,
                            'card_last_four' => NULL,
                            'amount'         => $amount,
                            'currency'       => $currency,
                            'is_accepted'    => NULL,
                            'ends_at'        => $ends_at,
                            'created_at'     => Carbon::now(),
                            'updated_at'     => Carbon::now(),
                        ]);

                        // Send Admin Notification
                        $admin = User::where('is_admin', 1)->where('id', 1)->first();
                        $admin->notify(new NewAdPayment([
                            'ad_id'          => $ad_id,     
                            'method'         => 'paysafecard',       
                            'type'           => 'ad',       
                            'transaction_id' => $payment_id,        
                            'user_id'        => Auth::id()
                        ]));

                        // Add Payment Notification to databse
                        DB::table('notifications_payments')->insert([
                            'user_id'          => Auth::id(),
                            'payment_id'       => $setPayment,
                            'transaction_id'   => $payment_id,
                            'payment_method'   => 'paysafecard',
                            'payment_type'     => 'ad',
                            'payment_amount'   => $amount,
                            'payment_currency' => $currency,
                            'created_at'       => Carbon::now(),
                            'updated_at'       => Carbon::now(),
                        ]);
                        
                        // Delete Session values
                        Session::forget('ad_upgrade_days');

                        // Thank the user for the upgrade
                        return redirect('/account/ads/'.$ad_id.'/checkout/paysafecard')->with('success', __('return/success.lang_payment_success'));

                    }else{

                        // retrieving the payment failed
                        return redirect('/account/ads/'.$ad_id.'/checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));

                    }

                }else{

                    // Payment Failed
                    return redirect('/account/ads/'.$ad_id.'/checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));

                }
            }else{

                // Payment Failed
                return redirect('/account/ads/'.$ad_id.'/checkout/paysafecard')->with('error', __('return/error.lang_payment_failed'));

            }

        }else{
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
        }
        
    }

}