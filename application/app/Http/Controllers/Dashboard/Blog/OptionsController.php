<?php

namespace App\Http\Controllers\Dashboard\Blog;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Image;

class OptionsController extends Controller
{
    
	/**
	 * Edit Article
	 */
	public function edit(Request $request, $id)
	{
		// check post id
		$article = Article::where('id', $id)->first();

		if ($article) {
			
			// Edit
			return view('dashboard.blog.edit', compact('article'));		

		}else{

			// Not found
			return redirect('dashboard/articles')->with('error', 'Oops! Article not found.');

		}
	}

	/**
	 * Update Article
	 */
	public function update(Request $request, $id)
	{
		// Check Article
		$article = Article::where('id', $id)->first();

		if ($article) {
			
			// Validate Form
			$request->validate([
				'title'   => [
				Rule::unique('articles')->ignore($id),
				'required',
				'max:255',
				], 
				'cover'   => 'image|mimes:png,jpg,jpeg|max:5000', 
				'content' => 'required'
			]);

			// Get Form Data
			$title             = $request->get('title');
			$cover             = $request->file('cover');
			$content           = $request->get('content');
			
			// Generate Slug
			$slug              = str_slug($title, '-');

			// Check if request has file
			if ($request->hasFile('cover')) {

				// Upload Cover
				$cover_name        = $slug.'.jpg';
				$cover_img         = Image::make($cover->getRealPath());
				$cover_img->encode('jpg', 60);
				$cover_img->save(public_path('uploads/articles').'/'.$cover_name, 60);

				// Update Article
				$article->update([
					'title'   => $title,
					'cover'   => $cover_name,
					'slug'    => $slug.'.html',
					'content' => $content,
				]);

				// Success
				return redirect('dashboard/articles')->with('success', 'Congratulations! Article has been successfully updated.');

			}else{

				// Update Article
				$article->update([
					'title'   => $title,
					'slug'    => $slug.'.html',
					'content' => $content,
				]);

				// Success
				return redirect('dashboard/articles')->with('success', 'Congratulations! Article has been successfully updated.');

			}



		}else{

			// Not found
			return redirect('dashboard/articles')->with('error', 'Oops! Article not found.');

		}
	}

	/**
	 * Delete Article
	 */
	public function delete(Request $request, $id)
	{
		// Check article
		$article = Article::where('id', $id)->first();

		if ($article) {
			
			// Delete Article
			$article->delete();

			// Success
			return redirect('dashboard/articles')->with('success', 'Congratulations! Article has been successfully deleted');

		}else{

			// Not found
			return redirect('dashboard/articles')->with('error', 'Oops! Article not found.');

		}
	}

}
