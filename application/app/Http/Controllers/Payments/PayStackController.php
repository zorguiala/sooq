<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paystack;
use Response;
use Validator;
use Carbon\Carbon;
use App\Models\Subscription;
use App\Notifications\Payments\Admin\NewAccountPayment;
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
    public function get()
    {
        // Check if gateway is enabled
        if (!Helper::settings_payments()->is_paystack) {
            
            // Not enabled
            return redirect('upgrade')->with('error', __('update.lang_gateway_not_enabled'));

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

        return view($this->theme.'.checkout.paystack');
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function post()
    {
        try {
            
            return Paystack::getAuthorizationUrl()->redirectNow();

        } catch (\Exception $e) {
            
            return redirect('/checkout/paystack')->with('error', 'Oops! '.$e->getMessage());

        }
        
    }

    /**
     * PayStack Callback
     */
    public function callback(Request $request)
    {
        // Check if ad payment
        if (Session::get('paystack_ad_upgrade')) {

            // Get ad id
            $ad_id     = Session::get('paystack_ad_upgrade');
            
            $trxref    = $request->get('trxref');
            $reference = $request->get('reference');

            return redirect('account/ads/'.$ad_id.'/checkout/paystack/callback?trxref='.$trxref.'&reference='.$reference);
        }

        $payment = Paystack::getPaymentData();

        // Check payment status
        if ($payment['status']) {
            
            // Check the amount
            $amount                       = $payment['data']['amount'];
            
            // Check days
            $days                         = $amount / (config('paystack.account_price') * 100);
            
            // Set Expire date
            $ends_at                      = Carbon::now()->addDays($days);
            
            // Payment ID
            $payment_id                   = $payment['data']['id'];
            
            // Payment Success, Create new Subscription
            $subscription                 = new Subscription;
            $subscription->user_id        = Auth::id();
            $subscription->days           = $days;
            $subscription->brand          = 'paystack';
            $subscription->transaction_id = $payment_id;
            $subscription->card_number    = NULL;
            $subscription->exp_year       = NULL;
            $subscription->exp_month      = NULL;
            $subscription->cvv            = NULL;
            $subscription->card_last_four = NULL;
            $subscription->amount         = $amount / 100;
            $subscription->currency       = config('paystack.currency');
            $subscription->is_accepted    = NULL;
            $subscription->ends_at        = $ends_at;
            $subscription->save();

            // Send Admin Notification
            $admin = User::where('is_admin', 1)->where('id', 1)->first();

            $admin->notify(new NewAccountPayment([
                'user_id'        => Auth::id(),
                'method'         => 'paystack',       
                'type'           => 'account',      
                'transaction_id' => $payment_id,        
                'user_id'        => Auth::id()
            ]));

            // Add Payment Notification to databse
            DB::table('notifications_payments')->insert([
                'user_id'          => Auth::id(),
                'payment_id'       => $subscription->id,
                'transaction_id'   => $payment_id,
                'payment_method'   => 'paystack',
                'payment_type'     => 'account',
                'payment_amount'   => $amount / 100,
                'payment_currency' => config('paystack.currency'),
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ]);

            // Thank the user for the upgrade
            return redirect('/checkout/paystack')->with('success', __('return/success.lang_payment_success'));

        }else{

            // Payment Failed
            return redirect('checkout/paystack')->with('error', __('return/error.lang_payment_failed'));

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
                $amount = config('paystack.account_price') * $days * 100;

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