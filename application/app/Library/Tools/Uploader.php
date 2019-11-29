<?php

namespace App\Library\Tools;

use Image;
use DB;
use Validator;
use Protocol;
use Helper;

/**
*
* Uploader
*
* @author MendelMan <ezzaroual@mail.com>
* @category Media
* @link http://mendelman.com
* @copyright 2017 MendelManGroup
*
*/
class Uploader
{
	
	/**
	 * Upload Photos
	 */
	public static function upload($photos, $ad_id)
	{
		// Get Uploads Folder
		$uploads_folder    = public_path().'/uploads/images/';
		
		// Create New Foler
		$images_folder     = mkdir($uploads_folder.$ad_id, 0777);
		
		// Create Thumbnails Folder
		$thumbnails_folder = mkdir($uploads_folder.$ad_id.'/thumbnails/', 0777);
		
		// Create Previews Folder 
		$previews_folder   = mkdir($uploads_folder.$ad_id.'/previews/', 0777);
		
		// Count Photos
		$count_photos      = count($photos);
		
		// Upload files Counter
		$uploadCounter     = 0;

		// Upload & Move Photos
		foreach ($photos as $photo) {
			
			// Make Rules
			$rules = array(
				'photo' => 'required|image|max:'.Helper::getMaxImageSize('php').'|mimes:png,jpg,jpeg'
			);

			// Make Rules on Photos
		    $validator = Validator::make(array('photo'=> $photo), $rules);

		    // Check if Passes
		    if($validator->passes()){

				// Make new thumbnail name
				$thumb_name   = 'thumbnail_'.$uploadCounter.'.jpg';
				
				// Upload Thumbnails
				$thumb_img    = Image::make($photo->getRealPath());

				// Get Ration
				$ratio        = $thumb_img->width() / $thumb_img->height();
				
				// New Width
				$targetWidth  = 270 * $ratio;
				
				// New Height
				$targetHeight = $targetWidth / $ratio;

				// Resize Thumbnails
				$thumb_img->resize($targetWidth, $targetHeight);
				
				// Save Thumbnails
				$thumb_img->save(public_path().'/uploads/images/'.$ad_id.'/thumbnails/'.$thumb_name, 100);
				
				// Make new preview name
				$preview_name   = 'preview_'.$uploadCounter.'.jpg';
				
				// Upload Thumbnails
				$preview_img    = Image::make($photo->getRealPath());
				
				/*// New Sizes
				$resposniveSize = self::resposniveSize($preview_img->width(), $preview_img->height());
				
				// Resize Thumbnails
				$preview_img->resize($resposniveSize[0], $resposniveSize[1]);*/
				
				// Check if Watermark enabled or not
				$is_watermark   = self::is_watermark();

		    	if ($is_watermark) {
		    		
		    		// Get Watermark Options
		    		$watermark = $is_watermark['watermark'];
		    		$position  = $is_watermark['position'];

		    		// Insert Watermark
		    		$preview_img->insert($watermark, $position);

		    	}

		    	// Encode image
		    	$preview_img->encode('jpg', 100);

				// Save Preview
				$preview_img->save(public_path().'/uploads/images/'.$ad_id.'/previews/'.$preview_name, 100);

				// New Counter
		        $uploadCounter ++;

		    }

		}

		if($uploadCounter == $count_photos){

			// Return Previews Array
			$previews_array   = array();
			
			// Return Thumbnails Array
			$thumbnails_array = array();

			for ($i = 0 ; $i <= $count_photos - 1 ; $i++) { 
				
				array_push($previews_array, '/'.$ad_id.'/previews/preview_'.$i.'.jpg');
				array_push($thumbnails_array, '/'.$ad_id.'/thumbnails/thumbnail_'.$i.'.jpg');

			}

			// Return Data
			$data  = array(
				'previews_array'   => $previews_array, 
				'thumbnails_array' => $thumbnails_array, 
			);

	      	return $data;

	    }else{
	      	
	    	return FALSE;

	    }

	}

	/**
	 * Edit Ad Images
	 */
	public static function edit($photos, $ad_id)
	{

		// Get Images Folder
		$previews_folder  = public_path().'/uploads/images/'.$ad_id.'/previews/';

		// Get thumbnails folder
		$thumbnails_folder = public_path().'/uploads/images/'.$ad_id.'/thumbnails/';

		// Delete Folder files
		self::deleteFolderFiles($previews_folder);
		self::deleteFolderFiles($thumbnails_folder);
		
		// Count Photos
		$count_photos      = count($photos);
		
		// Upload files Counter
		$uploadCounter     = 0;

		// Upload & Move Photos
		foreach ($photos as $photo) {
			
			// Make Rules
			$rules = array(
				'photo' => 'required|image|max:'.Helper::getMaxImageSize('php').'|mimes:png,jpg,jpeg'
			);

			// Make Rules on Photos
		    $validator = Validator::make(array('photo'=> $photo), $rules);

		    // Check if Passes
		    if($validator->passes()){

				// Make new thumbnail name
				$thumb_name   = 'thumbnail_'.$uploadCounter.'.jpg';
				
				// Upload Thumbnails
				$thumb_img    = Image::make($photo->getRealPath());

				// Get Ration
				$ratio        = $thumb_img->width() / $thumb_img->height();
				
				// New Width
				$targetWidth  = 270 * $ratio;
				
				// New Height
				$targetHeight = $targetWidth / $ratio;

				// Resize Thumbnails
				$thumb_img->resize($targetWidth, $targetHeight);
				
				// Save Thumbnails
				$thumb_img->save(public_path().'/uploads/images/'.$ad_id.'/thumbnails/'.$thumb_name, 100);
				
				// Make new preview name
				$preview_name = 'preview_'.$uploadCounter.'.jpg';
				
				// Upload Thumbnails
				$preview_img  = Image::make($photo->getRealPath());
				
				// New Sizes
				$resposniveSize = self::resposniveSize($preview_img->width(), $preview_img->height());
				
				// Resize Thumbnails
				$preview_img->resize($resposniveSize[0], $resposniveSize[1]);

				// Check if Watermark enabled or not
		    	$is_watermark = self::is_watermark();

		    	if ($is_watermark) {
		    		
		    		// Get Watermark Options
		    		$watermark = $is_watermark['watermark'];
		    		$position  = $is_watermark['position'];

		    		// Insert Watermark
		    		$preview_img->insert($watermark, $position);

		    	}

		    	// Encode image
		    	$preview_img->encode('jpg', 100);

				// Save Thumbnails
				$preview_img->save(public_path().'/uploads/images/'.$ad_id.'/previews/'.$preview_name, 100);

				// New Counter
		        $uploadCounter ++;

		    }

		}

		if($uploadCounter == $count_photos){

			// Return Previews Array
			$previews_array   = array();
			
			// Return Thumbnails Array
			$thumbnails_array = array();

			for ($i = 0 ; $i <= $count_photos - 1 ; $i++) { 
				
				array_push($previews_array, '/'.$ad_id.'/previews/preview_'.$i.'.jpg');
				array_push($thumbnails_array, '/'.$ad_id.'/thumbnails/thumbnail_'.$i.'.jpg');

			}

			// Return Data
			$data  = array(
				'previews_array'   => $previews_array, 
				'thumbnails_array' => $thumbnails_array, 
			);

	      	return $data;

	    }else{
	      	
	    	return FALSE;

	    }
	}

	/**
	 * Check if Watermark Enabed
	 */
	public static function is_watermark()
	{
		$watermark = DB::table('settings_watermark')->where('id', 1)->first();

		// Check if watermark is enabled
		if ($watermark->is_active) {

			// Check position
			switch ($watermark->position) {
				case 'top_right':
					$position = 'top-right';
					break;

				case 'top_left':
					$position = 'top-left';
					break;

				case 'bottom_right':
					$position = 'bottom-right';
					break;

				case 'bottom_left':
					$position = 'bottom-left';
					break;
				
				default:
					$position = 'center';
					break;
			}

			$data = array(
				'watermark' => public_path().'/uploads/settings/watermark/'.$watermark->watermark, 
				'position'  => $position
			);

			return $data;

		}else{

			// Not active
			return false;

		}
	}

	/**
	 * Delete folder files
	 */
	public static function deleteFolderFiles($dirPath)
	{
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
            unlink($file);
	    }

	    return;
	}

	/**
	 * Delete Folder with files
	 */
	public static function recursiveRemoveDirectory($directory)
	{
	    foreach(glob("{$directory}/*") as $file)
	    {
	        if(is_dir($file)) { 
	            self::recursiveRemoveDirectory($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($directory);
	}

	/**
	 * Upload Avatar
	 * @param string $avatar
	 * @param boolean $edit
	 * @return string $avatar_link
	 */
	public static function upload_avatar($avatar, $username)
	{
		// Get time
		$time        = md5(time().microtime());
		
		// Make new name
		$avatar_name = $username.'-'.$time.'.png';
		
		// Upload Avatar
		$avatar_img  = Image::make($avatar->getRealPath());
		
		// Resize Avatar
		$avatar_img->resize(100, 100);
		
		// Save Avatar
		$avatar_img->save(public_path().'/uploads/avatars/'.$avatar_name);
		
		// Avatar link
		$avatar_link = Protocol::home().'/application/public/uploads/avatars/'.$avatar_name;

		return $avatar_link;
	}

	/**
	 * Upload Avatar from URL
	 * @param string $avatar
	 * @return string $avatar_link
	 */
	public static function upload_avatar_url($avatar, $username)
	{
		try {

			// Get time
			$time        = md5(time().microtime());
			
			// Make new name
			$avatar_name = $username.'-'.$time.'.png';
			
			// Upload Avatar
			$avatar_img  = Image::make($avatar);
			
			// Resize Avatar
			$avatar_img->resize(100, 100);
			
			// Save Avatar
			$avatar_img->save(public_path().'/uploads/avatars/'.$avatar_name);
			
			// Avatar link
			$avatar_link = Protocol::home().'/application/public/uploads/avatars/'.$avatar_name;

			return $avatar_link;
			
		} catch (\Exception $e) {
			
			// Something went wrong
			return 'avatar.png';

		}	
	}

	/**
	 * Make responsive sizes
	 * @param $originalHeight & $originalWidth
	 * @return array 
	 */
	public static function resposniveSize($originalWidth, $originalHeight)
	{
		// Get Ration
		$ratio        = $originalWidth / $originalHeight;
		
		// New Width
		$targetWidth  = intval(500 * $ratio);
		
		// New Height
		$targetHeight = intval($targetWidth / $ratio);

		return array($targetWidth, $targetHeight);
	}
	
}