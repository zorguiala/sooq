<?php 

namespace App\Library\Tools;

use Config;

/**
* Theme Class
* @author MendelManGroup
* @link www.mendelmangroup.com
*/
class Theme
{
	
	/**
	* Set Theme
	*/
	public static function set($theme)
	{
		// Check if theme folder exists
		if (is_dir(resource_path('views/themes/'.$theme))) {
			
			// Set new theme
			Config::write('view', ['theme' => $theme]);

			return true;

		}else{

			// Theme folder not exists
			return false;

		}
	}

	// Get Default Theme
	public static function get()
	{
		return 'themes.'.config('view.theme');
	}
}