<?php 

namespace App\Library\Tools;

use Facebook;

/**
 * AutoShare Posts to facebook twitter  and istagram
 * @package Media
 * @author MendelManGroup <ezzaroual@mail.com>
 */

class AutoShare
{
	
	/**
	 * Auto share to facebook
	 */
	public static function facebook($link, $message, $picture, $name, $caption, $description)
	{

		// Get user application details
		$fb = new Facebook([
			'app_id'                => '1512670975417908',
			'app_secret'            => 'f78007976e9d565c32c428b0b42bc474',
			'default_graph_version' => 'v2.8',
		]);


		// Article Details
		$data = [
			'link'        => $link,
			'message'     => $message,
			"picture"     => $picture,
			"name"        => $name,
			"caption"     => $caption,
			"description" => $description
		];

		// Access Token
		$accessToken ='EAAVfxCgm3jQBAICXEtz4ecbh7ZCiv6COvDlLFRRt5j8G74D0MsZCkfwSMPf8xlTT4IhWG2Fh5cCDCTlxXOH3cAZC5nVaBIwaETZAyn2MnhcV5l1JulX9dLZAfj0b987tPAZBZAMPkCyPMM0k0tZC4UfcLBWdC7Fb2XYJQ4hmyYZA2GJycQnHkXJKkL7p9IvchXwiXdnSwf1w2uQZDZD';// See: https://developers.facebook.com/tools/explorer/1512670975417908

		// Start posting
		try {

	 		$response = $fb->post('/me/feed', $data, $accessToken);

		} catch (Facebook\Exceptions\FacebookResponseException $e) {
	 		// Error
	 		return FALSE;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
	 		// Error 
	 		return FALSE;
		}

		// Success
		return TRUE;
	}
}