<?php

namespace App\Http\Controllers\Ads\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Razorpay\Api\Api;
use App\Models\Subscription;
use App\Models\Ad;
use App\Notifications\Payments\Admin\NewAdPayment;
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


    public function get(Request $request, $ad_id)
    {       

        // Get user id
        $user_id = Auth::id();

        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if (!$ad) {
            
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));

        }

        // Check if gateway is enabled
        if (!Helper::settings_payments()->is_razorpay) {
            
            // Not enabled
            return redirect('account/ads/upgrade/'.$ad_id)->with('error', __('update.lang_gateway_not_enabled'));

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

        return view($this->theme.'.account.ads.checkout.razorpay', compact('ad'));
    }

    public function post(Request $request, $ad_id)
    {

        // Get user id
        $user_id = Auth::id();

        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if (!$ad) {
            
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));

        }

        // Make rules
        $rules = array(
            'days' => 'required|numeric', 
        );

        // Make validation
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            
            // Days must be between 7 days
            if ($request->get('days') < 7) {
                // Error
                return redirect('account/ads/'.$ad_id.'/checkout/razorpay')->with('error', 'Oops! Days must be greater than week');
            }

            // Return to RazorPay Gateway
            return redirect('account/ads/'.$ad_id.'/checkout/razorpay/progress?days='.$request->get('days'));

        }else{

            // Error
            return redirect('account/ads/'.$ad_id.'/checkout/razorpay')->withErrors($validator);

        }
    }

    /**
    * Pregress Payment
    */
    public function progress(Request $request, $ad_id)
    {

        // Get user id
        $user_id = Auth::id();

        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if (!$ad) {
            
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));

        }

        // Get days
        $days = $request->get('days');

        // Check days
        if (is_numeric($days)) {

            // Days must be between 7 days
            if ($days < 7) {
                // Error
                return redirect('account/ads/'.$ad_id.'/checkout/razorpay')->with('error', 'Oops! Days must be greater than week');
            }

            // Generate Amount
            $amount = (config('razorpay.ad_price') * $days) * 100;
            
            // Get data
            $data = array(
                'amount' => $amount, 
                'days'   => $days, 
                'ad'     => $ad, 
            );

            // Get Tilte && Description
            $title      = Helper::settings_general()->title;
            $long_desc  = Helper::settings_seo()->description;
            $keywords   = Helper::settings_seo()->keywords;

            // Manage SEO
            SEO::setTitle(__('update_three.lang_razorpay_checkout').' | '.$title);
            SEO::setDescription($long_desc);
            SEO::opengraph()->setUrl(Protocol::home());
            SEOMeta::addKeyword([$keywords]);

            // Progress payment
            return view($this->theme.'.account.ads.checkout.razorpay_progress')->with($data);

        }else{

            // Invalid days numbers
            return redirect('/account/ads/'.$ad_id.'checkout/razorpay')->with('error', 'Oops! Invalid days format.');

        }
    }

    /**
    * Checkout
    */
    public function checkout(Request $request, $ad_id)
    {

        // Get user id
        $user_id = Auth::id();

        // Check if ad exists
        $ad      = Ad::where('ad_id', $ad_id)->where('user_id', $user_id)->where('is_trashed', 0)->where('status', 1)->first();

        if (!$ad) {
            
            // Not found
            return redirect('/account/ads')->with('error', __('return/error.lang_ad_not_found'));

        }

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
                $days                         = $total_price / config('razorpay.ad_price');
                
                // Get currency
                $currency                     = $response->currency;
                
                // Set Expire Date
                $ends_at                      = Carbon::now()->addDays($days);

                // Payment Success, Create new ad payment
                $setPayment = DB::table('ads_payments')->insertGetId([
                    'user_id'        => $user_id,
                    'ad_id'          => $ad_id,
                    'days'           => $days,
                    'brand'          => 'razorpay',
                    'transaction_id' => $response->id,
                    'card_number'    => NULL,
                    'exp_year'       => NULL,
                    'exp_month'      => NULL,
                    'cvv'            => NULL,
                    'card_last_four' => NULL,
                    'amount'         => $total_price,
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
                    'method'         => 'razorpay',     
                    'type'           => 'ad',       
                    'transaction_id' => $response->id,      
                    'user_id'        => $user_id
                ]));

                // Add Payment Notification to databse
                DB::table('notifications_payments')->insert([
                    'user_id'          => Auth::id(),
                    'payment_id'       => $setPayment,
                    'transaction_id'   => $response->id,
                    'payment_method'   => 'razorpay',
                    'payment_type'     => 'ad',
                    'payment_amount'   => $total_price,
                    'payment_currency' => $currency,
                    'created_at'       => Carbon::now(),
                    'updated_at'       => Carbon::now(),
                ]);

                // Thank the user for the upgrade
                return redirect('account/ads/'.$ad_id.'/checkout/razorpay')->with('success', __('return/success.lang_payment_success'));

                

            } catch (\Exception $e) {
                
                // Error
                return redirect('account/ads/'.$ad_id.'/checkout/razorpay')->with('error', $e->getMessage());

            }
        }
    }
}