<?php

namespace App\Http\Controllers\Dashboard\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Validator;
use Image;
use Auth;

class ArticlesController extends Controller
{
    function __construct()
    {
    	$this->middleware('admin');
    }

    /**
     * Get All articles
     */
    public function articles()
    {
    	// Get articles
    	$articles = Article::orderBy('id', 'desc')->paginate(30);

    	return view('dashboard.blog.articles', compact('articles'));
    }

    /**
     * Create new Article
     */
    public function create()
    {
    	return view('dashboard.blog.create');
    }

    /**
     * Insert Article
     */
    public function insert(Request $request)
    {
    	// Make rules
    	$rules = array(
			'title'   => 'required|max:255|unique:articles', 
			'cover'   => 'image|mimes:png,jpg,jpeg|max:5000', 
			'content' => 'required'
    	);

    	// Make Validation
    	$validator = Validator::make($request->all(), $rules);

    	if ($validator->fails()) {
    		
    		// error
    		return redirect('/dashboard/articles')->withErrors($validator)->withInput();

    	}else{

			// Get Inputs
			$title             = $request->get('title');
			$cover             = $request->file('cover');
			$content           = $request->get('content');
			
			// Get Online admin username
			$username          = Auth::user()->username;
			
			// Generate Slug
			$slug              = str_slug($title, '-');
			
			// Upload Cover
			if($request->hasFile('cover')){
			$cover_name        = $slug.'.jpg';
			$cover_img         = Image::make($cover->getRealPath());
			$cover_img->encode('jpg', 60);
			$cover_img->save(public_path('uploads/articles').'/'.$cover_name, 60);
			}
			
			// Save Article
			$article           = new Article;
			$article->username = $username;
			$article->title    = $title;
			$article->slug     = $slug.'.html';
			if($request->hasFile('cover')){
			$article->cover    = $cover_name;
			}
			$article->content  = $content;
			$article->save();

			// Success
			return redirect('/dashboard/articles')->with('success', 'Article has been successfully added.');

    	}

    }
}
