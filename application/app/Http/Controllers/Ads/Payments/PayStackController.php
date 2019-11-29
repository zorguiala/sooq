<?php

namespace App\Http\Controllers\Ads\Payments;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paystack;
use Response;
use Validator;
use Carbon\Carbon;
use App\Models\Ad;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAdPayment;
use DB;
use App\User;
use Auth;
use Helper;
use Session;
use SEOMeta;
use SEO;
use Protocol;
use Theme;

class PayStackController extends Controller
{
    public $theme = '';
    
    function __construct()
    {
        $this->middleware('auth');
        $this->theme = Theme::get();
    }

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function get(Request $request, $ad_id)
    {
        // Get user id
        $user_id = Auth::id();
        
        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if ($ad) {

            // Check if gateway is enabled
            if (!Helper::settings_payments()->is_paystack) {
                
                // Not enabled
                return redirect('account/ads/upgrade/'.$ad_id)->with('error', __('update.lang_gateway_not_enabled'));

            }

            // Get Tilte && Description
            $title      = Helper::settings_general()->title;
            $long_desc  = Helper::settings_seo()->description;
            $keywords   = Helper::settings_seo()->keywords;

            // Manage SEO
            SEO::setTitle(__('update.lang_paystack_checkout').' | '.$title);
            SEO::setDescription($long_desc);
            SEO::opengraph()->setUrl(Protocol::home());
            SEOMeta::addKeyword([$keywords]);

            return view($this->theme.'.account.ads.checkout.paystack', compact('ad'));

        }else{
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function post(Request $request, $ad_id)
    {
        // Get user id
        $user_id = Auth::id();
        
        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if ($ad) {

            try {
                
                Session::put('paystack_ad_upgrade', $ad_id);

                return Paystack::getAuthorizationUrl()->redirectNow();

            } catch (\Exception $e) {
                
                return redirect('account/ads/'.$ad_id.'/checkout/paystack')->with('error', 'Oops! '.$e->getMessage());

            }

        }else{
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));
        }
        
    }

    /**
     * PayStack Callback
     */
    public function callback(Request $request, $ad_id)
    {
        $payment = Paystack::getPaymentData();

        // Check payment status
        if ($payment['status']) {
            
            // Check the amount
            $amount                       = $payment['data']['amount'];
            
            // Check days
            $days                         = $amount / (config('paystack.ad_price') * 100);
            
            // Set Expire date
            $ends_at                      = Carbon::now()->addDays($days);
            
            // Payment ID
            $payment_id                   = $payment['data']['id'];

            // Payment Success, Create new ad payment
            $setPayment = DB::table('ads_payments')->insertGetId([
                'user_id'        => Auth::id(),
                'ad_id'          => $ad_id,
                'days'           => $days,
                'brand'          => 'paystack',
                'transaction_id' => $payment_id,
                'card_number'    => NULL,
                'exp_year'       => NULL,
                'exp_month'      => NULL,
                'cvv'            => NULL,
                'card_last_four' => NULL,
                'amount'         => $amount / 100,
                'currency'       => config('paystack.currency'),
                'is_accepted'    => NULL,
                'ends_at'        => $ends_at,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]);

            // Send Admin Notification
            $admin = User::where('is_admin', 1)->where('id', 1)->first();
            $admin->notify(new NewAdPayment([
                'ad_id'          => $ad_id,     
                'method'         => 'paystack',       
                'type'           => 'ad',       
                'transaction_id' => $payment_id,        
                'user_id'        => Auth::id()
            ]));

            // Add Payment Notification to databse
            DB::table('notifications_payments')->insert([
                'user_id'          => Auth::id(),
                'payment_id'       => $setPayment,
                'transaction_id'   => $payment_id,
                'payment_method'   => 'paystack',
                'payment_type'     => 'ad',
                'payment_amount'   => $amount / 100,
                'payment_currency' => config('paystack.currency'),
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ]);

            // Delete Session
            Session::forget('paystack_ad_upgrade');

            // Thank the user for the upgrade
            return redirect('account/ads')->with('success', __('return/success.lang_payment_success'));

        }else{

            // Payment Failed
            return redirect('account/ads')->with('error', __('return/error.lang_payment_failed'));

        }
    }

    /**
     * Get Amount
     */
    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            
            // Make validation
            $validator = Validator::make($request->all(), [
                'days' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                
                // Error
                $response = array(
                    'status' => 'error', 
                    'msg'    => 'Oops! Please put a valid days number.', 
                );

                return Response::json($response);

            }else{

                // Get days
                $days = $request->get('days');

                // Check if days greater than 10
                if ($days < 10) {
                    // Error
                    $response = array(
                        'status' => 'error', 
                        'msg'    => 'Oops! Days must be greater than 10 days', 
                    );

                    return Response::json($response);
                }

                // Calcul Amount
                $amount = config('paystack.ad_price') * $days * 100;

                // Error
                $response = array(
                    'status' => 'success',
                    'amount' => $amount, 
                );

                return Response::json($response);

            }

        }
    }
}