<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Store;
use App\Models\Ad;
use Validator;
use DB;
use Helper;
use Carbon\Carbon;
use Image;
use Protocol;

/**
* CategoriesController
*/
class CategoriesController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Get Categories
	 */
	public function categories()
	{
		// Categories
		$categories = DB::table('categories')->orderBy('id', 'desc')->paginate(30);

		return view('dashboard.categories.categories')->with('categories', $categories);
	}

	/**
	 * Create New Category
	 */
	public function create()
	{
		return view('dashboard.categories.create');
	}

	/**
	 * Insert New Category
	 */
	public function insert(Request $request)
	{
		// Make Rules
		$rules = array(
			'category_name'   => 'required', 
			'category_slug'   => 'required',
			'is_sub'          => 'boolean',
			'parent_category' => 'numeric',
			'icon' 			  => 'required|image|mimes:png,jpg,jpeg|max:2000',
		);

		// Make Rules on Inputs
		$validator = Validator::make($request->all(), $rules);

		// Check if Catch errors
		if ($validator->fails()) {
			
			// Return error catched
			return back()->withErrors($validator)->withInput();

		}else{

			// Get Inputs values
			$category_name   = $request->input('category_name');
			$category_slug   = $request->input('category_slug');
			$is_sub          = $request->input('is_sub');
			$icon            = $request->file('icon');
			$parent_category = $request->get('parent_category');

			// Check if parent category
			if (!$is_sub) {

				// Category slug must be unique for parent categories
				$this->validate($request, [
					'category_slug' => 'unique:categories,category_slug',
				]);

				$parent_category = null;

			}else{

				// Get parent category
				$parent_category = $request->get('parent_category');

				// Check if parent category exists
				$check_parent = DB::table('categories')->where('id', $parent_category)->where('is_sub', 0)->first();

				if (!$check_parent) {
					return back()->with('error', 'Oops! Parent category not found. Please try again.');
				}

				// Set sub category to true
				$is_sub          = true;
			}

			// Upload icon
			$icon_name = md5(time()).'.png';
				
			// Upload Icon
			$icon_img  = Image::make($icon->getRealPath());
			
			// Resize Icon
			$icon_img->resize(50, 50);
			
			// Save Avatar
			$icon_img->save(public_path().'/uploads/categories/'.$icon_name);
			
			// Create icon url
			$icon_url  = Protocol::home().'/application/public/uploads/categories/'.$icon_name;


			// Insert New Category
			DB::table('categories')->insert([
				'category_name'   => $category_name,
				'category_slug'   => $category_slug,
				'is_sub'          => $is_sub,
				'parent_category' => $parent_category,
				'icon'            => $icon_url,
				'created_at'      => Carbon::now(),
				'updated_at'      => Carbon::now(),
			]);

			// Success
			return back()->with('success', 'Congratulations! Category has been successfully added.');

		}
	}

	/**
	 * Edit Category
	 */
	public function edit(Request $request, $id)
	{
		// Check category id
		$category = DB::table('categories')->where('id', $id)->first();

		if ($category) {
			
			return view('dashboard.categories.edit')->with('category', $category);

		}else{
			// Not found
			return redirect('/dashboard/categories')->with('error', 'Oops! Category not found.');
		}
	}

	/**
	 * Update Category
	 */
	public function update(Request $request, $id)
	{

		// Check if category exists
		$category = DB::table('categories')->where('id', $id)->first();

		if (!$category) {
			
			// Not found
			return redirect('/dashboard/categories')->with('error', 'Oops! Category not found.');

		}
		// Make Rules
		$rules = array(
			'category_name'   => 'required', 
			'category_slug'   => 'required',
			'icon' 			  => 'image|mimes:png,jpg,jpeg|max:500',
		);

		// Make Rules on Inputs
		$validator = Validator::make($request->all(), $rules);

		// Check if Catch errors
		if ($validator->fails()) {
			
			// Return error catched
			return back()->withErrors($validator);

		}else{

			// Get Inputs values
			$category_name = $request->input('category_name');
			$category_slug = $request->input('category_slug');
			$icon          = $request->file('icon');

			// Check if category slug or name already taken
			$check_category = DB::table('categories')->where('id', '!=', $id)->first();

			if ($check_category) {
				if (($check_category->category_slug == $category_slug) OR ($check_category->category_name == $category_name)) {
					return back()->with('error', 'Oops! Category name or slug already taken. Please try again.');
				}
			}

			// Insert New Category
			DB::table('categories')->where('id', $id)->update([
				'category_name'   => $category_name,
				'category_slug'   => $category_slug,
				'updated_at'      => Carbon::now(),
			]);

			if ($icon) {
				
				// Upload icon
				$icon_name = md5(time()).'.png';
					
				// Upload Icon
				$icon_img  = Image::make($icon->getRealPath());
				
				// Resize Icon
				$icon_img->resize(50, 50);
				
				// Save Avatar
				$icon_img->save(public_path().'/uploads/categories/'.$icon_name);
				
				// Create icon url
				$icon_url  = Protocol::home().'/application/public/uploads/categories/'.$icon_name;

				DB::table('categories')->where('id', $id)->update([
					'icon'   => $icon_url,
				]);

			}

			// Success
			return back()->with('success', 'Congratulations! Category has been successfully updated.');

		}
	}

	/**
	 * Delete Category
	 */
	public function delete(Request $request, $id)
	{
		// Check category
		$category = Category::where('id', $id)->first();

		if ($category) {

			// Check if category is parent category
			if (!$category->is_sub) {
				
				// Check if there is at less one other parent category
				$other_category = Category::where('id', '!=', $id)->where('is_sub', 0)->first();

				if (!$other_category) {
					// Other Category Not found
					return redirect('/dashboard/categories')->with('error', 'Oops! There no other categories. Please try again.');
				}

				// Get sub categories
				$sub_categories = Category::where('parent_category', $category->id)->get();

				// Change parent category for this sub categories
				foreach ($sub_categories as $sub) {
					
					Category::where('id', $sub->id)->update([
						'parent_category' => $other_category->id
					]);

				}

				// Delete category, but before change ads,stores category
				Ad::where('category', $id)->update([
					'category' => $other_category->id
				]);

				// Change store Category
				Store::where('category', $id)->update([
					'category' => $other_category->id
				]);

				// Delete Category
				Category::where('id', $id)->delete();

			}else{

				// Check if other category exists
				$other_category = Category::where('id', '!=', $id)->first();

				if (!$other_category) {
					// Other Category Not found
					return redirect('/dashboard/categories')->with('error', 'Oops! There no other categories. Please try again.');
				}

				// Move ads to other category
				Ad::where('category', $id)->update([
					'category' => $other_category->id
				]);

				// Change store Category
				Store::where('category', $id)->update([
					'category' => $other_category->id
				]);

				// Delete Category
				Category::where('id', $id)->delete();

			}

			// Success
			return redirect('/dashboard/categories')->with('success', 'Category has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/categories')->with('error', 'Oops! Category not found or is not a sub category.');
		}
	}

}