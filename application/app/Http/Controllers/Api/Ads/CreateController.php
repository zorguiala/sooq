<?php

namespace App\Http\Controllers\Api\Ads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Random;
use Auth;

class CreateController extends Controller
{
    
    /**
     * Create new ad
     * @return [type] [description]
     */
	public function create(Request $request)
	{
		
		// Make rules
		$rules = array(
			'title'                => 'required|max:100',
			'description'          => 'required', 
			'category'             => 'required|numeric|exists:categories,id', 
			'price'                => 'required', 
			'currency'             => 'required|exists:currencies,code', 
			'negotiable'           => 'required|boolean', 
			//'terms'                => 'required', 
			'condition'            => 'required|boolean', 
			'photos'               => 'required', 
			'affiliate_link'       => 'active_url' 
		);

		// Make validation
		$request->validate($rules);

		// Get inputs
		$title       = $request->get('title');
		$description = $request->get('description');
		$category    = $request->get('category');
		//$country     = $request->get('country');
		//$state       = $request->get('state');
		//$city        = $request->get('city');
		$price       = $request->get('price');
		$currency    = $request->get('currency');
		$is_used     = $request->get('condition');
		$negotiable  = $request->get('negotiable');
		//$latitude    = $request->get('latitude');
		//$longitude   = $request->get('longitude');
		//$radius      = $request->get('radius');
		
		// Create New Ad ID
		$ad_id       = Random::unique();

		// Generate AD Slug
		$slug        = Random::slug($title, $ad_id);
		
		// Get User ID
		$user_id     = Auth::id();

		// Create Ad Dates
		$created_at  = Carbon::now();
		$updated_at  = Carbon::now();
		$ends_at     = Helper::ad_ends_at();

		

	}

}
