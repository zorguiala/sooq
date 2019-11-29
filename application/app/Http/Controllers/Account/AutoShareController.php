<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use Validator;
use Helper;
use SEO;
use SEOMeta;
use Protocol;
use Profile;
use Theme;

/**
* AutoShareController class
*/
class AutoShareController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
		$this->middleware('auth');
        $this->theme = Theme::get();
	}

	/**
	 * Auto Share Settings
	 */
	public function autoshare()
	{
		// Get user id
		$user_id = Auth::id();

		// Check if user has store
		if (!Profile::hasStore($user_id)) {
			// Error
			return redirect('/create/store');
		}

		// Get User Auto Share Settings
		$autoshare = DB::table('auto_share')->where('user_id', $user_id)->first();

		if ($autoshare) {
			
			// Get Tilte && Description
	        $title      = Helper::settings_general()->title;
	        $long_desc  = Helper::settings_seo()->description;
	        $keywords   = Helper::settings_seo()->keywords;

	        // Manage SEO
	        SEO::setTitle(__('title.lang_autoshare_settings').' | '.$title);
	        SEO::setDescription($long_desc);
	        SEO::opengraph()->setUrl(Protocol::home());
	        SEOMeta::addKeyword([$keywords]);

			return view($this->theme.'.account.autoshare')->with('autoshare', $autoshare);

		}else{

			// Create Default Settings
			DB::table('auto_share')->insert([
				'user_id'                => $user_id,
				'fb_active'              => false,
				'tw_active'              => false,
				'tg_active'              => false,
				'tw_consumer_key'        => null,
				'tw_consumer_secret'     => null,
				'tw_access_token'        => null,
				'tw_access_token_secret' => null,
				'fb_app_id'              => null,
				'fb_app_secret'          => null,
				'fb_access_token'        => null,
				'tg_api_token'           => null,
				'tg_bot_username'        => null,
				'tg_channel_username'    => null,
				'tg_channel_signature'   => null,
				'created_at'             => Carbon::now(),
				'updated_at'             => Carbon::now(),
			]);

			// Get User Auto Share Settings
			$autoshare = DB::table('auto_share')->where('user_id', $user_id)->first();

			return view($this->theme.'.account.autoshare')->with('autoshare', $autoshare);

		}
	}

	/**
	 * Update AutoShare Settings
	 */
	public function update(Request $request)
	{

		// Get user id
		$user_id = Auth::id();

		// Check if user has store
		if (!Profile::hasStore($user_id)) {
			// Error
			return redirect('/create/store');
		}

		// Make Rules
		$rules = array(
			'fb_active'              => 'required|boolean',
			'tw_active'              => 'required|boolean',
			'tg_active'              => 'required|boolean',
		);

		// Run Rules
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {

			// Get Inputs values
			$fb_active              = $request->get('fb_active');
			$tw_active              = $request->get('tw_active');
			$tw_consumer_key        = $request->get('tw_consumer_key');
			$tw_consumer_secret     = $request->get('tw_consumer_secret');
			$tw_access_token        = $request->get('tw_access_token');
			$tw_access_token_secret = $request->get('tw_access_token_secret');
			$fb_app_id              = $request->get('fb_app_id');
			$fb_app_secret          = $request->get('fb_app_secret');
			$fb_access_token        = $request->get('fb_access_token');
			$tg_active              = $request->get('tg_active');
			$tg_api_token           = $request->get('tg_api_token');
			$tg_bot_username        = $request->get('tg_bot_username');
			$tg_channel_username    = $request->get('tg_channel_username');
			$tg_channel_signature   = $request->get('tg_channel_signature');
			$updated_at             = Carbon::now();
			
			// Save Data
			DB::table('auto_share')->where('user_id', $user_id)->update([
				'fb_active'              => $fb_active,
				'tw_active'              => $tw_active,
				'tw_consumer_key'        => $tw_consumer_key,
				'tw_consumer_secret'     => $tw_consumer_secret,
				'tw_access_token'        => $tw_access_token,
				'tw_access_token_secret' => $tw_access_token_secret,
				'fb_app_id'              => $fb_app_id,
				'fb_app_secret'          => $fb_app_secret,
				'fb_access_token'        => $fb_access_token,
				'tg_active'              => $tg_active,
				'tg_api_token'           => $tg_api_token,
				'tg_bot_username'        => $tg_bot_username,
				'tg_channel_username'    => $tg_channel_username,
				'tg_channel_signature'   => $tg_channel_signature,
				'updated_at'             => $updated_at, 
			]);

			// Success
			return back()->with('success', __('return/success.lang_settings_updated'));

		}else{

			// Error
			return back()->withErrors($validator);

		}
	}

}