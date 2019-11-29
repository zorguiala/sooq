<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Helper;
use SEO;
use SEOMeta;
use Protocol;
use OpenGraph;
use Theme;

class HomeController extends Controller
{
    public $theme = '';
	
	function __construct()
	{
        $this->theme = Theme::get();
	}
    
	/**
	 * Get Blog home page
	 */
	public function index()
	{
		// Get Articles
		$articles = Article::orderBy('id', 'desc')->paginate(30);

		// Get Tilte && Description
		$title      = Helper::settings_general()->title;
		$long_desc  = Helper::settings_seo()->description;
		$keywords   = Helper::settings_seo()->keywords;

		// Manage SEO
		SEO::setTitle(__('update_two.lang_blog').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home().'/blog');
        SEOMeta::addKeyword([$keywords]);

		return view($this->theme.'.blog.index', compact('articles'));
	}

	/**
	 * Show article
	 */
	public function article($slug)
	{
		
		// Check article slug
		$article = Article::where('slug', $slug)->first();

		if ($article) {

			// Get Tilte && Description
			$title           = Helper::settings_general()->title;
			$keywords        = Helper::settings_seo()->keywords;
			
			// Create Seo Description
			$seo_description = substr(trim(preg_replace('/\s+/', ' ', $article->content)), 0, 150);

			// Manage SEO
			SEO::setTitle($article->title.' | '.$title);
	        SEO::setDescription($seo_description);
	        SEO::opengraph()->setUrl(Protocol::home().'/blog/'.$article->slug);
	        SEOMeta::addKeyword([$keywords]);
	        OpenGraph::addProperty('type', 'article')->setArticle([
					'published_time'  => $article->created_at,
					'modified_time'   => $article->updated_at,
	        ]);
	        OpenGraph::addImage(Protocol::home().'/application/public/uploads/articles/' .$article->cover);
			
			// Show post
			return view($this->theme.'.blog.article', compact('article'));

		}else{

			// Not found
			abord('404');

		}

	}

}
