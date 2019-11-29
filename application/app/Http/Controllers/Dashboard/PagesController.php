<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Helper;
use Carbon\Carbon;

/**
* PagesController
*/
class PagesController extends Controller
{
	function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * Create New Page
	 */
	public function create()
	{
		return view('dashboard.pages.create');
	}

	/**
	 * Insert Page
	 */
	public function insert(Request $request)
	{
		// Make Rules
		$rules = array(
			'page_name'    => 'required|unique:pages',
			'page_slug'    => 'required|unique:pages',
			'page_content' => 'required',
			'page_col'     => 'required|in:column_one,column_two,column_three,column_four',
		);

		// Make Validation
		$validator = Validator::make($request->all(), $rules);

		//Check if passes
		if ($validator->fails()) {

			// Error
			return back()->withErrors($validator)->withInput();

		}else{

			// Get Inputs values
			$page_slug    = $request->get('page_slug');
			$page_name    = $request->get('page_name');
			$page_content = $request->get('page_content');
			$page_col     = $request->get('page_col');

			switch ($page_col) {
				case 'column_one':
					$col = 'col1';
					break;
				case 'column_two':
					$col = 'col2';
					break;
				case 'column_three':
					$col = 'col3';
					break;
				case 'column_four':
					$col = 'col4';
					break;
				
				default:
					$col = 'col1';
					break;
			}

			// Save New Page
			DB::table('pages')->insert([
				'page_name'    => $page_name,
				'page_slug'    => $page_slug,
				'page_content' => $page_content,
				'page_col'     => $col,
				'created_at'   => Carbon::now(),
				'updated_at'   => Carbon::now(),
			]);

			// Reutn success
			return back()->with('success', 'Congratulations! Page has been successfully added.');


		}
	}

	/**
	 * Get Pages
	 */
	public function pages()
	{
		// Get Pages
		$pages = DB::table('pages')->orderBy('id', 'desc')->paginate(30);

		return view('dashboard.pages.pages')->with('pages', $pages);
	}

	/**
	 * Edit Pages
	 */
	public function edit(Request $request, $slug)
	{
		// Get Page
		$page = DB::table('pages')->where('page_slug', $slug)->first();

		if ($page) {
			
			return view('dashboard.pages.edit')->with('page', $page);

		}else{
			// Not found
			return redirect('/dashboard/pages')->with('error', 'Oops! Page not found.');
		}
	}
	
	/**
	 * Update Page
	 */
	public function update(Request $request, $slug)
	{

		// Get Page
		$page = DB::table('pages')->where('page_slug', $slug)->first();

		if ($page) {
			
			// Make Rules
			$rules = array(
				'page_name'    => 'required',
				'page_slug'    => 'required',
				'page_content' => 'required',
				'page_col'     => 'required|in:column_one,column_two,column_three,column_four',
			);

			// Make Validation
			$validator = Validator::make($request->all(), $rules);

			//Check if passes
			if ($validator->fails()) {

				// Error
				return back()->withErrors($validator)->withInput();

			}else{

				// Get Inputs values
				$page_slug    = $request->get('page_slug');
				$page_name    = $request->get('page_name');
				$page_content = $request->get('page_content');
				$page_col     = $request->get('page_col');

				switch ($page_col) {
				case 'column_one':
					$col = 'col1';
					break;
				case 'column_two':
					$col = 'col2';
					break;
				case 'column_three':
					$col = 'col3';
					break;
				case 'column_four':
					$col = 'col4';
					break;
				
				default:
					$col = 'col1';
					break;
			}

				// Check double pages slug
				$double_pages = DB::table('pages')->where('page_slug', '!=', $slug)->first();

				if ($double_pages) {

					if (($double_pages->page_slug == $page_slug) OR ($double_pages->page_name == $page_name)) {
						
						return back()->with('error', 'Oops! Page name or slug already taken. Please try again.');

					}

				}

				// Save New Page
				DB::table('pages')->where('page_slug', $slug)->update([
					'page_name'    => $page_name,
					'page_slug'    => $page_slug,
					'page_content' => $page_content,
					'page_col'     => $col,
					'updated_at'   => Carbon::now(),
				]);

				// Reutn success
				return redirect('/dashboard/pages/edit/'.$page_slug)->with('success', 'Congratulations! Page has been successfully added.');

			}

		}else{
			// Not found
			return redirect('/dashboard/pages')->with('error', 'Oops! Page not found.');
		}

	}

	/**
	 * Delete Page
	 */
	public function delete(Request $request, $slug)
	{
		// Get Page
		$page = DB::table('pages')->where('page_slug', $slug)->first();

		if ($page) {

			// Delete Page
			DB::table('pages')->where('page_slug', $slug)->delete();

			return redirect('/dashboard/pages')->with('success', 'Page has been successfully deleted.');

		}else{
			// Not found
			return redirect('/dashboard/pages')->with('error', 'Oops! Page not found.');
		}
	}

}
