<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Mail\PaymentAccepted;
use App\Mail\PaymentRefused;
use Illuminate\Support\Facades\Mail;
use Validator;
use DB;
use Helper;
use App\User;
use App\Models\Ad;
use App\Models\Store;
use Carbon\Carbon;
use Auth;

/**
* PaymentsController
*/
class PaymentsController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Accounts Payments History
	 */
	public function accounts()
	{
		// Get user id
		$user_id = Auth::id();

		if ($user_id != 1) {
			// Only admin can change these
			return redirect('/dashboard')->with('error', 'Oops! This section is not available for you.');
		}
		// Get Payments
		$payments = Subscription::orderBy('id', 'desc')->paginate(30);

		return view('dashboard.payments.accounts')->with('payments', $payments);
	}

	/**
	 * Accept Payment 
	 */
	public function account_accept(Request $request, $id)
	{
		// Check payment 
		$payment = Subscription::where('id', $id)->where('is_accepted', null)->first();

		if ($payment) {
			
			// Accept Payment
			Subscription::where('id', $id)->update([
				'is_accepted' => 1
			]);

			// Update user account
			User::where('id', $payment->user_id)->update([
				'account_type'  => 1,
				'has_store'     => 1,
				'store_ends_at' => $payment->ends_at,
			]);

			// Check if has store
			$store = Store::where('owner_id', $payment->user_id)->first();

			if ($store) {
				// Update Store
				Store::where('owner_id', $payment->user_id)->update([
					'status'  => '1', 
					'ends_at' => $payment->ends_at, 
				]);
			}

			// Get user email
			$email = User::where('id', $payment->user_id)->select('email')->first();

			// Send an email to this user
			Mail::to($email)->send(new PaymentAccepted()); 

			// success
			return redirect('/dashboard/payments/accounts')->with('success', 'Payment has been successfully accepted.');

		}else{
			// Not found
			return redirect('/dashboard/payments/accounts')->with('error', 'Oops! Payment not found.');
		}
	}

	/**
	 * Refuse Payment 
	 */
	public function account_refuse(Request $request, $id)
	{
		// Check payment 
		$payment = Subscription::where('id', $id)->where('is_accepted', null)->first();

		if ($payment) {
			
			// Refuse Payment
			Subscription::where('id', $id)->update([
				'is_accepted' => 0
			]);

			// Get user email
			$email = User::where('id', $payment->user_id)->select('email')->first();

			// Send an email to this user
			Mail::to($email)->send(new PaymentRefused()); 

			// success
			return redirect('/dashboard/payments/accounts')->with('success', 'Payment has been successfully refused.');

		}else{
			// Not found
			return redirect('/dashboard/payments/accounts')->with('error', 'Oops! Payment not found.');
		}
	}

	/**
	 * ADS Payments History
	 */
	public function ads()
	{
		// Get Payments
		$payments = DB::table('ads_payments')->orderBy('id', 'desc')->paginate(30);

		return view('dashboard.payments.ads')->with('payments', $payments);
	}

	/**
	 * Accept Payment 
	 */
	public function ads_accept(Request $request, $id)
	{
		// Check payment 
		$payment = DB::table('ads_payments')->where('id', $id)->where('is_accepted', null)->first();

		if ($payment) {
			
			// Accept Payment
			DB::table('ads_payments')->where('id', $id)->update([
				'is_accepted' => 1
			]);

			// Make Ad Featured
			Ad::where('ad_id', $payment->ad_id)->update([
				'is_featured' => 1,
				'is_archived' => 0,
				'status'      => 1,
				'ends_at'     => $payment->ends_at,
			]);

			// Send notification
			DB::table('notifications_ads_accepted')->insert([
				'user_id'    => $payment->user_id,
				'ad_id'      => $payment->ad_id,
				'created_at' => Carbon::now(),
			]);

			// Get user email
			$email = User::where('id', $payment->user_id)->select('email')->first();

			// Send an email to this user
			Mail::to($email)->send(new PaymentAccepted()); 

			// success
			return redirect('/dashboard/payments/ads')->with('success', 'Payment has been successfully accepted.');

		}else{
			// Not found
			return redirect('/dashboard/payments/ads')->with('error', 'Oops! Payment not found.');
		}
	}

	/**
	 * Refuse Payment 
	 */
	public function ads_refuse(Request $request, $id)
	{
		// Check payment 
		$payment = DB::table('ads_payments')->where('id', $id)->where('is_accepted', null)->first();

		if ($payment) {
			
			// Refuse Payment
			DB::table('ads_payments')->where('id', $id)->update([
				'is_accepted' => 0
			]);

			// Get user email
			$email = User::where('id', $payment->user_id)->select('email')->first();

			// Send an email to this user
			Mail::to($email)->send(new PaymentRefused()); 

			// success
			return redirect('/dashboard/payments/ads')->with('success', 'Payment has been successfully refused.');

		}else{
			// Not found
			return redirect('/dashboard/payments/ads')->with('error', 'Oops! Payment not found.');
		}
	}

}