<?php



namespace App\Http\Controllers\Dashboard\Ads;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Notifications\AdAccepted;

use App\Notifications\AdRefused;

use App\Notifications\AdDeleted;

use App\User;

use Validator;

use DB;

use Helper;

use App\Models\Ad;

use Carbon\Carbon;

use Auth;



/**

* OptionsController

*/

class OptionsController extends Controller

{



	function __construct()

	{

		$this->middleware('admin');

	}



	/**

	 * Active Ad

	 */

	public function active(Request $request, $ad_id)

	{

		// Check ad

		$ad =  Ad::where('ad_id', $ad_id)->where('status', 0)->first();



		if ($ad) {



			// Active Ad

			Ad::where('ad_id', $ad_id)->update([

				'status' => 1

			]);



			// Send notifications to user

			DB::table('notifications_ads_accepted')->insert([

				'ad_id'      => $ad->ad_id,

				'user_id'    => $ad->user_id,

				'created_at' => Carbon::now(),

			]);



			// Send email notification

			$user = User::where('id', $ad->user_id)->first();

			$user->notify(new AdAccepted($ad->ad_id));



			return redirect('/dashboard/ads')->with('success', 'Congratulations! Ad has been successfully activated.');



		}else{

			// Not found or Already active

			return redirect('/dashboard/ads')->with('error', 'Oops! Ad not found or already activated.');

		}

	}



	/**

	 * Inactive Ad

	 */

	public function inactive(Request $request, $ad_id)

	{

		// Check ad

		$ad =  Ad::where('ad_id', $ad_id)->where('status', 1)->first();



		if ($ad) {

			

			// Get user id

			$user_id = Auth::id();



			// Cannot inactive admin ads

			if (($ad->user_id == 1) && ($user_id != 1)) {

				return redirect('/dashboard/ads')->with('error', 'Oops! You cannot incative this ad.');

			}



			// Active Ad

			Ad::where('ad_id', $ad_id)->update([

				'status' => 0

			]);



			// Send email notification

			$user = User::where('id', $ad->user_id)->first();

			$user->notify(new AdRefused($ad->ad_id));



			return redirect('/dashboard/ads')->with('success', 'Congratulations! Ad has been successfully inactivated.');



		}else{

			// Not found or Already inactivated

			return redirect('/dashboard/ads')->with('error', 'Oops! Ad not found or already inactivated.');

		}

	}



	/**

	 * Delete Ad

	 */

	public function delete(Request $request, $ad_id)

	{

		// Check ad

		$ad = Ad::where('ad_id', $ad_id)->first();



		if ($ad) {

			

			// Get user id

			$user_id = Auth::id();



			// Cannot inactive admin ads

			if (($ad->user_id == 1) && ($user_id != 1)) {

				return redirect('/dashboard/ads')->with('error', 'Oops! You cannot delete this ad.');

			}



			// Delete relationships with this ad

			DB::table('stats')->where('ad_id', $ad_id)->delete();

			DB::table('comments')->where('ad_id', $ad_id)->delete();

			DB::table('offers')->where('ad_id', $ad_id)->delete();

			DB::table('notifications_ads')->where('ad_id', $ad_id)->delete();

			DB::table('notifications_ads_accepted')->where('ad_id', $ad_id)->delete();

			DB::table('notifications_comments')->where('ad_id', $ad_id)->delete();

			DB::table('notifications_likes')->where('ad_id', $ad_id)->delete();

			DB::table('notifications_reports')->where('ad_id', $ad_id)->delete();

			DB::table('ads_payments')->where('ad_id', $ad_id)->delete();

			DB::table('favorites')->where('ad_id', $ad_id)->delete();

			DB::table('users_mailbox')->where('ad_id', $ad_id)->delete();



			// Now delete All uploads

			Helper::deleteDir(public_path().'/uploads/images/'.$ad->ad_id);



			// Delete Ad

			Ad::where('ad_id', $ad_id)->delete();



			// Send email notification

			$user = User::where('id', $ad->user_id)->first();

			$user->notify(new AdDeleted($ad->title));



			return redirect('/dashboard/ads')->with('success', 'Congratulations! Ad has been successfully deleted.');



		}else{

			// Not found

			return redirect('/dashboard/ads')->with('error', 'Oops! Ad not found.');

		}

	}



}