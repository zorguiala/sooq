<?php 

namespace App\Library\Cloud;

use Storage;
use Uploader;
use Image;
use Protocol;

/**
* @author Mendelman
* Manage images using External Clouds
*/
class EverestCloud
{
	
	private $driver;

	function __construct($driver)
	{
		$this->driver = $driver;
	}

	/**
	* Upload images to Amazon S3
	* @var $photos string
	* @return $response boolean
	*/
	public static function uploadToAmazon($photos, $ad_id)
	{

		// Start Uploading to Amazon Cloud
		try {

			// Set loop couter
			$counter = 0;

			// Count photos
			$count_photos      = count($photos);

			// Manage each image
			foreach ($photos as $photo) {
				
				$preview_name   = 'preview_'   . $counter . '.jpg';
				$thumbnail_name = 'thumbnail_' . $counter . '.jpg';

				$image = Image::make($photo);

				// Get Ration
				$ratio        = $image->width() / $image->height();

				/**
				* Upload first thumbnails
				*/
				$targetThumbWidth  = intval(270 * $ratio);
				$targetThumbHeight = intval($targetThumbWidth / $ratio);

				// Resize Thumbnail
				$thumbNewSize      = $image->fit($targetThumbWidth, $targetThumbHeight)->stream();

				Storage::disk('s3')->put('photos/'.$ad_id.'/thumbnails/'.$thumbnail_name, $thumbNewSize->__toString());
				Storage::disk('s3')->setVisibility('photos/'.$ad_id.'/thumbnails/'.$thumbnail_name, 'public');

				/**
				* Now upload Preview images
				*/
				$resposniveSize = Uploader::resposniveSize($image->width(), $image->height());

				// Resize Thumbnail
				$previewNewSize      = $image->fit($resposniveSize[0], $resposniveSize[1])->stream();

				// Check if Watermark enabled or not
				$is_watermark   = Uploader::is_watermark();

				if ($is_watermark) {
		    		
		    		// Get Watermark Options
		    		$watermark = $is_watermark['watermark'];
		    		$position  = $is_watermark['position'];

		    		// Insert Watermark
		    		$image->insert($watermark, $position);

		    	}

		    	Storage::disk('s3')->put('photos/'.$ad_id.'/previews/'.$preview_name, $previewNewSize->__toString());
				Storage::disk('s3')->setVisibility('photos/'.$ad_id.'/previews/'.$preview_name, 'public');

				// New Counter
		        $counter ++;

			}

			if($counter == $count_photos){

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
		      	
		    	return false;

		    }
			
		} catch (\Exception $e) {
			
			/*echo $e->getMessage();
			die();*/
			return false;

		}
		
	}

	/**
	* Get thumnail url
	*/
	public static function getThumnail($ad_id, $host)
	{
		if ($host == 'local') {
			
			$thumb = Protocol::home().'/application/public/uploads/images/'.$ad_id.'/thumbnails/thumbnail_0.jpg';

		}else{

			$thumb = Storage::disk('s3')->url('photos/'.$ad_id.'/thumbnails/thumbnail_0.jpg');

		}

		return $thumb;
	}
}

 ?>