<?php

namespace App\Library\Config;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Models\Ad;
use App\Models\Stats;
use App\Models\Store;
use App\Models\Follow;
use App\Models\Rating;
use App\Models\Currency;
use App\User;
use Auth;
use Profile;
use Storage;
use Session;
use Config;

/**
* Helper Class
*/
class Helper
{
	
	/************ Make Database date readable ************/
	public static function date_ago($date)
	{
		return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
	}

	/*********** Count Days ***************/
	public static function date_string($date)
	{
		return Carbon::parse($date)->format('d/m/Y');
	}

	/**
	 * String Date
	 */
	public static function dateToFormatted($date)
	{
		return Carbon::parse($date)->toFormattedDateString(); 
	}

	/**
	 * Get username by id
	 */
	public static function username_by_id($id)
	{
		$user = User::where('id', $id)->first();

		if ($user) {
			return $user->username;
		}else{
			return 'N/A';
		}
	}

	/**
	 * Get id by username
	 */
	public static function id_by_username($username)
	{
		$user = User::where('username', $username)->first();

		if ($user) {
			return $user->id;
		}else{
			// Not found
			return 'N/A';
		}
		
	}

	/**
	 * Get All Parent Categories
	 */
	public static function parent_categories()
	{
		// Get Parent Cats
		$parent = DB::table('categories')->where('is_sub', false)->get();

		if ($parent) {
			return $parent;
		}else{
			return array();
		}
	}

	/**
	 * Get SubCategories
	 * @param integer $parent_category
	 * @return array $sub_categories
	 */
	public static function sub_categories($parent_category)
	{

		// Get Sub Categories
		$sub_categories = DB::table('categories')->where('is_sub', 1)->where('parent_category', $parent_category)->get();

		if ($sub_categories) {
			
			return $sub_categories;

		}else{

			return array();

		}

	}

	/**
	 * Get Parent Category
	 * @param integer $id
	 * @return array $parent
	 */
	public static function get_parent_category($id)
	{

		// Get Parent Category
		$category = DB::table('categories')->where('id', $id)->first();

		if ($category) {
			
			$parent = DB::table('categories')->where('id', $category->parent_category)->first();

			return $parent->category_name;

		}else{

			return  null;

		}

	}

	/**
	 * Get Parent Category
	 * @param integer $id
	 * @return array $parent
	 */
	public static function get_parent_category_slug($id)
	{

		// Get Parent Category
		$category = DB::table('categories')->where('id', $id)->first();

		if ($category) {

			return $category->category_slug;

		}else{

			return  null;

		}

	}

	/**
	 * Count Ads by category
	 * @param integer $id
	 * @return integer $ads
	 */
	public static function count_ads_by_category($id)
	{

		// Get Ads
		$ads = Ad::where('category', $id)->where('status', 1)->count();

		return $ads;

	}

	/**
	 * Count Ads by category && user
	 * @param integer $id, $user_id
	 * @return integer $ads
	 */
	public static function count_ads_by_category_user($id, $user_id)
	{

		// Get Ads
		$ads = Ad::where('category', $id)->where('user_id', $user_id)->where('status', 1)->count();

		return $ads;

	}

	/**
	 * Count Ads by Store
	 * @param integer $user_id
	 * @return integer $ads
	 */
	public static function count_store_ads($user_id)
	{

		// Get Ads
		$ads = Ad::where('user_id', $user_id)->count();

		return number_format($ads);

	}

	/**
	 * Count views by Store
	 * @param integer $user_id
	 * @return integer $ads
	 */
	public static function count_store_views($user_id)
	{

		// Get Views
		$views = Stats::where('owner', $user_id)->count();

		return number_format($views);

	}

	/**
	 * Count followers by Store
	 * @param integer $user_id
	 * @return integer $followers
	 */
	public static function count_store_followers($user_id)
	{

		// Get Store
		$store = Store::where('owner_id', $user_id)->first();

		// Get Followers
		$followers = Follow::where('store', $store->username)->count();

		return number_format($followers);

	}

	/**
	 * Count likes by Store
	 * @param integer $user_id
	 * @return integer $ads
	 */
	public static function count_store_likes($user_id)
	{

		// Get Ads
		$likes = DB::table('favorites')->where('owner', $user_id)->count();

		return number_format($likes);

	}

	/**
	 * Get Pages by column
	 */
	public static function get_pages($column)
	{
		$pages = DB::table('pages')->where('page_col', $column)->get();

		return $pages;
	}

	/**
	 * Get Store Details
	 */
	public static function get_store($owner_id)
	{
		$store = DB::table('stores')->where('owner_id', $owner_id)->first();

		return $store;
	}

	/**
	 * Get Store Details
	 * @param string $request
	 * @return string $return
	 */
	public static function store_details($username, $request)
	{
		// Get Store Details
		$store = Store::where('username', $username)->first();

		// Check if store exists
		if ($store) {
			
			// Check request
			switch ($request) {
				case 'title':
					return $store->title;
					break;

				case 'logo':
					return $store->logo;
					break;

				case 'status':
					return $store->status;
					break;
				
				default:
					return $store->username;
					break;
			}

		}else{

			// Not found
			return 'N/A';

		}

	}

	/**
	 * Get Data by CURL
	 * @param string $link
	 * @return data
	 */
	public static function curl($link)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_URL, $link);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
	    $data = curl_exec($ch);
	    curl_close($ch);

		return unserialize($data);
	}

	/**
	 * Make Image Src encoded
	 * @param string $img_src
	 * @return string $base64
	 */
	public static function img_src_base64($img_src)
	{

		try {
			
			// Get Image Type
			$type   = pathinfo($img_src, PATHINFO_EXTENSION);

			// Get Data
			$data   = file_get_contents($img_src);

			//$data   = self::curl($img_src);

			// encode data
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

			return $base64;
			
		} catch (\Exception $e) {
			return $img_src;
		}

	}

	/**
	 * Get Ad Photos
	 * @param string $photos
	 * @return string $return
	 */
	public static function ad_photos($photos, $host)
	{

		$return = '<div id="AdsSlider" class="royalSlider rsDefault">';

		// Explode photos by ||
		$explode = explode('||', $photos);
		
		foreach ($explode as $p) {

			if ($host == 'local') {
				
				$img = self::img_src_base64(Protocol::home().'/application/public/uploads/images'.$p);

			}else{

				// Get image from Amazon
				$img = Storage::disk('s3')->url('photos'.$p);

			}
			
			
			$return .= '<a class="rsImg bugaga" data-rsw="100%" data-rsh="500" data-rsbigimg="'.$img.'" href="'.$img.'"><img class="rsTmb" width="96" height="72" src="'.$img.'"></a>';
		}
		
		$return  .= '</div>';

		return $return;
	}

	/**
	* Get first image of ad
	*/
	public static function ad_first_image($ad_id, $host)
	{
		try {
			
			if ($host == 'local') {
				
				return Protocol::home().'/application/public/uploads/images/'.$ad_id.'/previews/preview_0.jpg';

			}else{

				// Get image from Amazon
				return Storage::disk('s3')->url('photos/'.$ad_id.'/previews/preview_0.jpg');

			}

		} catch (\Exception $e) {
			
			// Error
			return Protocol::home();
			//return $e->getMessage();

		}
	}

	/**
	 * Get Ad Category
	 * @param integer $category_id
	 * @return string $full_category
	 */
	public static function get_category($category_id, $link=false)
	{
		// Check category
		$category = DB::table('categories')->where('id', $category_id)->first();

		if ($category) {
			
			// Check if Parent or Sub Category
			if ($category->is_sub) {
				
				// Get Parent Category
				$parent = DB::table('categories')->where('id', $category->parent_category)->first();

				// Check if Request Link
				if ($link) {
					
					// Reutn Full Link to category
					return Protocol::home().'/category/'.$parent->category_slug .'/'. $category->category_slug;

				}

				// Return full category
				return $category->category_name;

			}else{

				// Check if Request Link
				if ($link) {
					
					// Reutn Full Link to category
					return Protocol::home().'/category/'.$category->category_slug;

				}

				// Return Parent Category
				return $category->category_name;

			}

		}else{

			// Invalid category id
			return 'Unknown Category';

		}
	}

	/**
	 * Delete a Dir
	 * @param string $dirPath
	 * @return boolean
	 */
	public static function deleteDir($dirPath) 
	{
	    if (! is_dir($dirPath)) {
	        return FALSE;
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);

	    return TRUE;
	}

	/**
	 * Check price
	 * @param string $price
	 * @return boolean
	 */
	public static function isCurrency($price)
	{

		try {
			
			$p     = str_replace([',', ' '], ['.', ''], $price);

			$match = '/\b\d{1,17}(?:,?\d{3})*(?:\.\d{2})?\b/';

			if (preg_match($match, $p)) {
				
				// Price format is valid
				return $p;

			}else{

				// Price format is wrong
				return false;

			}

		} catch (\Exception $e) {
			
			// Price format is wrong
			return false;

		}

	}

	/**
	 * Store Cover
	 * @param string $username
	 * @return string $cover
	 */
	public static function store_cover($username)
	{
		$store = Store::where('username', $username)->first();

		if ($store->cover == 'store_cover.png') {
			return Protocol::home().'/application/public/uploads/covers/default_cover.jpg';
		}else{
			return $store->cover;
		}
	}

	/**
	 * Check Status
	 * @return boolean
	 */
	public static function status($ad = true, $comment = false)
	{
		// Check Ad Status
		if ($ad) {
			if (Auth::user()->is_admin || Auth::user()->is_moderator || Profile::hasStore(Auth::id())) {
				return 1;
			}else{
				// Check Default Settings
				if (self::settings_security()->auto_approve_ads) {
					return true;
				}
				return false;
			}
		}

		// Check Comment Status
		if ($comment) {
			if (Auth::user()->is_admin || Auth::user()->is_moderator || Auth::user()->has_store) {
				return 1;
			}else{
				// Check Default Settings
				if (self::settings_security()->auto_approve_comments) {
					return true;
				}
				return false;
			}
		}
		
	}

	/**
	 * Get Offer Percentage
	 */
	public static function offer_percentage($price, $offer)
	{
		try {
			
			if (self::isCurrency($price) && self::isCurrency($offer)) {

				$percent = ($offer * 100) / $price;

				return number_format($percent - 100, 2);	

			}else{
				return 'N/A';
			}

		} catch (\Exception $e) {
			return 'N/A';
		}
		
	}

	/**
	 * Get Ad Details
	 * @param string $request
	 * @return string $return
	 */
	public static function ad_details($ad_id, $request)
	{
		// Get Ad Details
		$ad = Ad::where('ad_id', $ad_id)->first();

		// Check request
		switch ($request) {
			case 'title':
				return $ad->title;
				break;

			case 'category':
				return self::get_category($ad->category);
				break;

			case 'price':
				return self::getPriceFormat($ad->price, $ad->currency);
				break;

			case 'views':
				return number_format($ad->views);
				break;

			case 'likes':
				return number_format($ad->likes);
				break;

			case 'is_featured':
				return $ad->is_featured;
				break;

			case 'is_archived':
				return $ad->is_archived;
				break;
			case 'currency':
				return $ad->currency;
				break;
			
			default:
				return $ad->ad_id;
				break;
		}
	}

	/**
	 * Get Ad Status
	 * @param string $ad_id
	 * @return string $status
	 */
	public static function ad_status($ad_id)
	{
		// Get Ad Details
		$ad = Ad::where('ad_id', $ad_id)->first();

		if ($ad) {
			
			return $ad->status;
			
		}else{

			// Not found
			return 1;

		}

	}

	/**
	 * Get Ad Total comments
	 * @param string $ad_id
	 * @return string $comments
	 */
	public static function ad_comments($ad_id)
	{
		// Get Ad Details
		$ad       = Ad::where('ad_id', $ad_id)->first();
		
		// Get Comments
		$comments = DB::table('comments')->where('ad_id', $ad_id)->where('status', 1)->count();

		return $comments;
	}

	/**
	 * Get Advertisements
	 * @return $advertisements
	 */
	public static function advertisements()
	{
		// Get advertisements
		$advertisements = DB::table('advertisements')->where('id', 1)->first();

		return $advertisements;
	}

	/**
	 * Check if can see adsense advertisements
	 */
	public static function ifCanSeeAds()
	{
		if (Auth::check()) {
			
			if (Auth::user()->id == 1) {
				return true;
			}

			// Check if has store
			if (Profile::hasStore(Auth::id())) {
				return false;
			}else{
				return true;
			}

		}else{
			// TRUE
			return true;
		}
	}


	/**
	 * Get General Settings
	 * @return $settings
	 */
	public static function settings_general()
	{
		// Get Settings
		$settings = DB::table('settings_general')->where('id', 1)->first();

		return $settings;
	}

	/**
	 * Get SEO Settings
	 * @return $settings
	 */
	public static function settings_seo()
	{
		// Get Settings
		$settings = DB::table('settings_seo')->where('id', 1)->first();

		return $settings;
	}

	/**
	 * Get GEO Settings
	 * @return $settings
	 */
	public static function settings_geo()
	{
		// Get Settings
		$settings = DB::table('settings_geo')->where('id', 1)->first();

		return $settings;
	}

	/**
	 * Get Auth Settings
	 * @return $settings
	 */
	public static function settings_auth()
	{
		// Get Settings
		$settings = DB::table('settings_auth')->where('id', 1)->first();

		return $settings;
	}

	/**
	 * Get Security Settings
	 * @return $settings
	 */
	public static function settings_security()
	{
		// Get Settings
		$settings = DB::table('settings_security')->where('id', 1)->first();

		return $settings;
	}

	/**
	 * Get Membership Settings
	 * @return $settings
	 */
	public static function settings_membership()
	{
		// Get Settings
		$settings = DB::table('settings_membership')->where('id', 1)->first();

		return $settings;
	}

	/**
	 * Get Payments Settings
	 * @return $settings
	 */
	public static function settings_payments()
	{
		// Get Settings
		$settings = DB::table('settings_payments')->where('id', 1)->first();

		return $settings;
	}

	/**
	 * Count Notifications
	 * @return $total
	 */
	public static function count_notifications($type)
	{
		// Check type
		switch ($type) {
			case 'ads':
				$total = DB::table('notifications_ads')->where('is_read', 0)->count();
				break;

			case 'ads_accepted':
				$total = DB::table('notifications_ads_accepted')->where('user_id', Auth::id())->where('is_read', 0)->count();
				break;

			case 'comments':
				$total = DB::table('comments')->where('status', 0)->count();
				break;

			case 'user_comments':
				$total = DB::table('notifications_user_comments')->where('user_id', Auth::id())->where('is_read', 0)->count();
				break;

			case 'payments':
				$total = DB::table('notifications_payments')->where('is_read', 0)->count();
				break;

			case 'reports':
				$total = DB::table('notifications_reports')->where('is_read', 0)->count();
				break;

			case 'users':
				$total = DB::table('notifications_users')->where('is_read', 0)->count();
				break;

			case 'stores':
				$total = DB::table('notifications_stores')->where('is_read', 0)->count();
				break;

			case 'messages':
				$total = DB::table('admin_mailbox')->where('is_read', 0)->count();
				break;
			
			default:
				$total = 0;
				break;
		}

		// Total Notifications
		return $total;
	}

	/**
	 * Count User Notifications
	 * @return $total
	 */
	public static function count_user_notifications($type)
	{
		if (!is_null($type)) {
			
			// check type
			switch ($type) {
				case 'ads':
					$total = DB::table('notifications_ads_accepted')->where('user_id', Auth::id())->where('is_read', 0)->count();
					break;
				case 'comments':
					$total = DB::table('notifications_user_comments')->where('user_id', Auth::id())->where('is_read', 0)->count();
					break;
				case 'offers':
					$total = DB::table('offers')->where('offer_to', Auth::id())->where('is_accepted', NULL)->count();
					break;
				case 'messages':
					$total = DB::table('users_mailbox')->where('msg_to', Auth::user()->username)->where('is_read', 0)->count();
					break;
				case 'warnings':
					$total = DB::table('notifications_warnings')->where('user_id', Auth::id())->where('is_read', 0)->count();
					break;
				case 'likes':
					$total = DB::table('notifications_likes')->where('user_id', Auth::id())->where('is_read', 0)->count();
					break;
				case 'store_feedback':
					$total = DB::table('stores_feedback')->where('store', Profile::hasStore(Auth::id())->username)->where('is_read', 0)->count();
					break;
				
				default:
					$total = 0;
					break;
			}

			return $total;

		}else{
			// Count all notifications
			$ads      = DB::table('notifications_ads_accepted')->where('user_id', Auth::id())->where('is_read', 0)->count();
			
			$comments = DB::table('notifications_user_comments')->where('user_id', Auth::id())->where('is_read', 0)->count();
			
			$warnings = DB::table('notifications_warnings')->where('user_id', Auth::id())->where('is_read', 0)->count();
			
			$likes    = DB::table('notifications_likes')->where('user_id', Auth::id())->where('is_read', 0)->count();
			
			$messages = DB::table('users_mailbox')->where('msg_to', Auth::user()->username)->where('is_read', 0)->count();

			// Check if store has a store
			if (Profile::hasStore(Auth::id())) {
				$store_feedback = DB::table('stores_feedback')->where('store', Profile::hasStore(Auth::id())->username)->where('is_read', 0)->count();
			}else{
				$store_feedback = 0;
			}
			
			// Count
			$total    = $ads+$comments+$messages+$warnings+$likes+$store_feedback;

			return $total;
		}
	}	

	/**
	 * Get Date when ad move to archive
	 * @return string $ends_at
	 */
	public static function ad_ends_at()
	{
		// Get membership settings
		$settings = self::settings_membership();

		// Check if admin
		if (Auth::user()->is_admin) {
			
			// Ad will expire after 10 years
			$ends_at = Carbon::now()->addYears(10);

		}elseif (Profile::hasStore(Auth::id())) {

			// User has a store
			$ends_at = Carbon::now()->addDays($settings->pro_ad_life);

		}else{

			// Free account
			$ends_at = Carbon::now()->addDays($settings->free_ad_life);

		}

		return $ends_at;
	}

	/**
	 * Get Credit Card Last Four Digits
	 * @param $number integer
	 * @return $last_four integer
	 */
	public static function credit_last_four($number)
	{
		return substr($number, -4);
	}

	/**
	 * Obtain a brand constant from a PAN 
	 *
	 * @param type $pan Credit card number
	 * @return string
	 */
	public static function detectCardBrand($pan)
	{
	     // Available Credit Cards
	     $visa_regex       = "/^4[0-9]{0,}$/";
	     $mastercard_regex = "/^(5[1-5]|222[1-9]|22[3-9]|2[3-6]|27[01]|2720)[0-9]{0,}$/";
	     $maestro_regex    = "/^(5[06789]|6)[0-9]{0,}$/";
	     $amex_regex       = "/^3[47][0-9]{0,}$/";
	     $diners_regex     = "/^3(?:0[0-59]{1}|[689])[0-9]{0,}$/";
	     $discover_regex   = "/^(6011|65|64[4-9]|62212[6-9]|6221[3-9]|622[2-8]|6229[01]|62292[0-5])[0-9]{0,}$/";
	     $jcb_regex        = "/^(?:2131|1800|35)[0-9]{0,}$/";

	     // Detect Credit Card
	     if (preg_match($jcb_regex, $pan)) {
	          return "JCB";
	     }

	     if (preg_match($amex_regex, $pan)) {
	          return "AMEX";
	     }

	     if (preg_match($diners_regex, $pan)) {
	          return "DINERS CLUB";
	     }

	     if (preg_match($visa_regex, $pan)) {
	          return "VISA";
	     }

	     if (preg_match($mastercard_regex, $pan)) {
	          return "MASTERCARD";
	     }

	     if (preg_match($discover_regex, $pan)) {
	          return "DISCOVER";
	     }

	     if (preg_match($maestro_regex, $pan)) {
	          if ($pan[0] == '5') {
	               return "MASTERCARD";
	          } else {
	               return "MAESTRO";
	          }
	     }

	     // Uknown 
	     return "unknown";
	}

	/**
	 * Get Ad Slug
	 */
	public static function getSlug($ad_id)
	{
		$ad = Ad::where('ad_id', $ad_id)->first();

		return $ad->slug;
	}

	/**
	* Count rating avaerage
	* @param $ad_id string
	* @param $store_id integer
	* @return 
	*/
	public static function rating_average($ad_id, $store_id)
	{
		$total = Rating::where('ad_id', $ad_id)->where('store_id', $store_id)->where('is_approved', true)->count();

		if ($total > 0) {

			$stars1 = Rating::where('ad_id', $ad_id)->where('store_id', $store_id)->where('is_approved', true)->where('rating', 1)->count() * 100 / $total * 5 / 100;
			$stars2 = Rating::where('ad_id', $ad_id)->where('store_id', $store_id)->where('is_approved', true)->where('rating', 2)->count() * 100 / $total * 5 / 100;
			$stars3 = Rating::where('ad_id', $ad_id)->where('store_id', $store_id)->where('is_approved', true)->where('rating', 3)->count() * 100 / $total * 5 / 100;
			$stars4 = Rating::where('ad_id', $ad_id)->where('store_id', $store_id)->where('is_approved', true)->where('rating', 4)->count() * 100 / $total * 5 / 100;
			$stars5 = Rating::where('ad_id', $ad_id)->where('store_id', $store_id)->where('is_approved', true)->where('rating', 5)->count() * 100 / $total * 5 / 100;

			$avg = $stars1 + $stars2 + $stars3 + $stars4 + $stars5;

			return $avg;

		}else{
			return 0;
		}
	}

	/**
	* Get domain name and tld
	* @return $domain string
	*/
	public static function getDomain()
	{
		if (!empty(getenv('HTTPS')) && getenv('HTTPS') != 'off') {
		    
			// Secure connection
			$protocol = 'https://';

		}else{

			// Insecure Connection
			$protocol = 'http://';

		}

		// Get full url
		$url = $protocol.getenv('SERVER_NAME');

		$dots = explode('.', parse_url($url, PHP_URL_HOST));

		if (count($dots) == 3) {

			$domain = $dots[1].'.'.$dots[2];

		}else{
			
			$domain = $dots[0].'.'.$dots[1];

		}
		
		return $domain;
	}

	/**
	* Get Editor locale
	*/
	public static function editorLocale($justLocale = false)
	{
		// Get language
		if (Session::has('locale')) {

			$language = Session::get('locale');

		}else{

			// Defaul Language
            $language = Config::get('app.locale');

		}

		// Available languages
		$list = array(
			'ar' => 'ar-AR',  
			'cz' => 'cs-CZ', 
			'de' => 'de-DE', 
			'es' => 'es-ES', 
			'fr' => 'fr-FR',  
			'it' => 'it-IT', 
			'jp' => 'ja-JP', 
			'kr' => 'ko-KR', 
			'nl' => 'nl-NL', 
			'pl' => 'pl-PL', 
			'br' => 'pt-BR', 
			'ru' => 'ru-RU', 
			'sk' => 'sk-SK', 
			'se' => 'sv-SE', 
			'tr' => 'tr-TR', 
			'uk' => 'ua-UA', 
			'cn' => 'zh-CN', 
			'ct' => 'zh-TW' 
		);

		foreach ($list as $key => $value) {
			
			if ($language == $key) {
				
				$locale = $value;

			}else{

				$locale = 'fr-FR';

			}

		}

		if ($justLocale) {
			
			return $locale;

		}else{

			// Get url
			return Protocol::home().'/content/assets/front-end/js/plugins/editors/wysihtml5/locales/bootstrap-wysihtml5.'.$locale.'.js';

		}
		 
	}

	/**
	 * Get Max Image Size for JS & PHP validation
	 * @param  String $language JS/PHP
	 * @return String           Max Image Size (KB/B)
	 */
	public static function getMaxImageSize($language)
	{
		// Get Security Settings
		$settings = self::settings_security();

		// Check requested language
		switch ($language) {
			case 'js':
				// Convert Size to B
				$size = $settings->max_image_size * 1000 * 1000;
				break;

			case 'php':
				// Convert Size to KB
				$size = $settings->max_image_size * 1000;
				break;
			
			default:
				// Convert Size to KB
				$size = $settings->max_image_size * 1000;
				break;
		}
		
		// Return new size
		return $size;
	}

	/**
	 * Get Money format based on settings
	 * @param  string $price Price to change
	 * @return string $price New price format
	 */
	public static function getPriceFormat($price, $currency = 'USD')
	{

		try {
			
			// Check dafault settings for zeros (.00$)
			$trimTrailingZeros = config('settings.trim_trailing_zeros');

			// Generate a Valid Price Format
			if (self::isCurrency($price)) {
				
				$money  = self::isCurrency($price);

			}else{

				$money  = $price;

			}

			// Get currency loacle
			$locale = Currency::select('locale')->where('code', $currency)->first();
			
			// Generate new price and currency based on default locale currency
			$format = numfmt_create( $locale->locale, \NumberFormatter::CURRENCY );

			if ($trimTrailingZeros) {
				
				// Check if money format is clear
				if (strpos($money,'.') !== false) {

				    // Return new price format
					return numfmt_format_currency($format, $money, $currency);

				}else{

					// Remove zeros
					numfmt_set_attribute($format, \NumberFormatter::MAX_FRACTION_DIGITS, 0);

					// Return new price format
					return numfmt_format_currency($format, $money, $currency);

				}

			}else{

				// Return new price format
				return numfmt_format_currency($format, $money, $currency);

			}

		} catch (\Exception $e) {
			
			// Error
			return $money .' '.$currency;

		}

	}

	/**
	 * Check if latitude is valid or not
	 * @param  [type]  $latitude [description]
	 * @return boolean           [description]
	 */
	public static function isValidLatitude($latitude)
	{
	    if (preg_match("/^(\+|-)?(?:90(?:(?:\.0{1,8})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,8})?))$/", $latitude)) 
	    {
	        return true;
	    } else {
	        return false;
	    }
	}

	/**
	 * Check if longitude is valid or not
	 * @param  [type]  $longitude [description]
	 * @return boolean            [description]
	 */
	public static function isValidLongitude($longitude)
	{
	    if(preg_match("/^(\+|-)?(?:180(?:(?:\.0{1,8})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,8})?))$/",
	      $longitude)) 
	    {
	       return true;
	    } else {
	       return false;
	    }
	}

}