<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Config;

class ThemesController extends Controller
{
    
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	* Browse available themes
	**/
	public function browse()
	{
		// Get exist themes
		$themes = array_filter(glob(resource_path('views/themes/*')), 'is_dir');

		return view('dashboard.themes.browse', compact('themes'));
	}

	/**
	* Set new theme 
	**/
	public function set(Request $request)
	{
		
		// get theme name
		$theme = $request->get('theme');

		// Check if exists
		if (is_dir(resource_path('views/themes/'.$theme))) {
			
			// Change theme
			Config::write('view', [
				'theme' => $theme
			]);

			// Success
			return redirect('/dashboard/themes')->with('success', 'Theme has been successfuly changed');

		}else{

			// Not found
			return redirect('/dashboard/themes')->with('error', 'Oops! Theme not found');

		}

	}

}
