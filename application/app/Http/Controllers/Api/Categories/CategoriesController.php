<?php

namespace App\Http\Controllers\Api\Categories;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoriesController extends Controller
{
    
    /**
     * Get all categories
     * @return [type] [description]
     */
	public function categories()
	{
		$categories = Category::all();

		return response()->json(['categories' => $categories], 200, [], JSON_NUMERIC_CHECK);
	}

	/**
	 * Get ads by category (Parent/Sub categories)
	 * @param  [type] $parent [description]
	 * @param  [type] $child  [description]
	 * @return [type]         [description]
	 */
	public function category($parent, $child = null)
	{
		// Get parent category
		$parent_category = Category::where('category_slug', $parent)
		                           ->where('is_sub', false)
		                           ->first();

		if ($parent_category) {
			
			if (!is_null($child)) {

				// Check sub category
				$sub_category = Category::where('category_slug', $child)
				                        ->where('parent_category', $parent_category->id)
				                        ->first();

				if ($sub_category) {

					// Show ads in sub-category
					$ads = $sub_category->ads->all();

					return response()->json(['ads' => $ads], 200, []);

				}else{
					
					// Show ads in parent-category
					$ads = $parent_category->ads->all();

					return response()->json(['ads' => $ads], 200, []);

				}

			}else{

				// Show ads in parent-category
				$ads           = $parent_category->ads->all();

				// Get sub-categories
				$subCategories = Category::where('parent_category', $parent_category->id)
				                         ->where('is_sub', true)
				                         ->get();

				return response()->json(['ads' => $ads, 'categories'=> $subCategories], 200, []);

			}

		}else{
			
			// Category not found
			$response = array(
				'status'  => false, 
				'message' => 'Oops! Category not found.', 
			);

			return response()->json($response, 422, []);

		}
	}

}
