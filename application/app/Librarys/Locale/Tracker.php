<?php

namespace App\Library\Locale;

use Countries;

/**
* Tracker Class
*/
class Tracker
{
	
	public static $ip;

	public static function ip($getIp)
	{
		self::$ip = $getIp;

		return new self;
	}

	// Get API URL
	protected static function api()
	{
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    //curl_setopt($ch, CURLOPT_INTERFACE, self::$ip);
	    curl_setopt( $ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: ".self::$ip, "HTTP_X_FORWARDED_FOR: ".self::$ip));  
	    curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/".self::$ip);
	    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);     
	    $data = curl_exec($ch);
	    curl_close($ch);

	    return json_decode($data);
	}

	// Get Country
	public function country()
	{
		$data      = self::api();

		if ($data && $data->status == 'success') {
			
			// Get countries
			$countries = Countries::get();

			foreach ($countries as $code => $name) {
				if ($code == $data->countryCode) {
					return $name;
				}
			}

			// Failed to get country
			return 'United States';

		}else{

			// Failed to get country
			return 'United States';

		}
	}

	/**
	 * Get Country Code
	 */
	public function country_code()
	{
		$data = self::api();

		if ($data && $data->status == 'success') {

			return $data->countryCode;

		}else{

			// Failed to get country code
			return 'US';

		}
	}


	/**
	 * Get City Name
	 */
	public function city()
	{
		$data = self::api();

		if ($data && $data->status == 'success') {

			return $data->city;

		}else{

			// Failed to get City
			return 'Philadelphia';

		}
	}

	/**
	 * Get Region
	 */
	public function region()
	{
		$data = self::api();

		if ($data && $data->status == 'success') {

			return $data->regionName;

		}else{

			// Failed to get Region
			return 'Pennsylvania';

		}
	}

	/**
	 * Get Referrer
	 */
	public static function referrer()
	{
		return (!empty(getenv('HTTP_REFERER'))) ? getenv('HTTP_REFERER') : '';;
	}


	/**
	 * Get Referrer Keyword
	 */
	public static function referrer_keyword($url = '')
	{
		// Get the referrer
		$referrer = (!empty(getenv('HTTP_REFERER'))) ? getenv('HTTP_REFERER') : '';

		$referrer = (!empty($url)) ? $url : $referrer;

		if (empty($referrer)){
			return null;
		}

		// Parse the referrer URL
		$parsed_url = parse_url($referrer);
		if (empty($parsed_url['host'])){
			return null;
		}

		$host = $parsed_url['host'];
		$query_str = (!empty($parsed_url['query'])) ? $parsed_url['query'] : '';
		$query_str = (empty($query_str) && !empty($parsed_url['fragment'])) ? $parsed_url['fragment'] : $query_str;
		if (empty($query_str)){
			return null;
		}

		// Parse the query string into a query array
		parse_str($query_str, $query);

		// Check some major search engines to get the correct query var
		$search_engines = array(
			'q' => 'alltheweb|aol|ask|bing|google',
			'p' => 'yahoo',
			'wd' => 'baidu'
		);
		foreach ($search_engines as $query_var => $se)
		{
			$se = trim($se);
			preg_match('/(' . $se . ')\./', $host, $matches);
			if (!empty($matches[1]) && !empty($query[$query_var])){
				return $query[$query_var];
			}
		}
		return null;
	}
}