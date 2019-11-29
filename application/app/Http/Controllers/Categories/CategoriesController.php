<?php



namespace App\Http\Controllers\Categories;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DB;
use App\User;
use App\Models\Ad;

use App\Models\Category;

use Carbon\Carbon;

use Helper;

use SEO;

use SEOMeta;

use Protocol;

use Theme;



/**

* CategoriesController

*/

class CategoriesController extends Controller

{

    public $theme = '';

	

	function __construct()

	{

        $this->theme = Theme::get();

	}



	/**

	 * Get Categories

	 */

	public function category(Request $request, $parent, $sub=null)

	{

		// Check category

		$parent_category = DB::table('categories')->where('category_slug', $parent)->where('is_sub', false)->first();



		if ($parent_category) {

			

			if ($sub) {



				// Check sub category

				$sub_category = DB::table('categories')->where('category_slug', $sub)->where('parent_category', $parent_category->id)->first();



				if ($sub_category) {



					// Get filters

					$date      = $request->get('date');

					$status    = $request->get('status');

					$condition = $request->get('condition');



					// Check Date

					if ($date) {



						switch ($date) {

							case 'today':

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereRaw('Date(created_at) = CURDATE()')->orderBy('id', 'desc')->paginate(30);

								break;

							case 'yesterday':

								$yesterday = date("Y-m-d", strtotime( '-1 days' ) );

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereDate('created_at', $yesterday )->orderBy('id', 'desc')->paginate(30);

								break;

							case 'week':

								$fromDate = Carbon::now()->subDays(8)->format('Y-m-d');

								$tillDate = Carbon::now()->format('Y-m-d');

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereBetween( DB::raw('date(created_at)'), [$fromDate, $tillDate] )->orderBy('id', 'desc')->paginate(30);

								break;

							case 'month':

								$fromDate = Carbon::now()->subDays(31)->format('Y-m-d');

								$tillDate = Carbon::now()->format('Y-m-d');

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereBetween( DB::raw('date(created_at)'), [$fromDate, $tillDate] )->orderBy('id', 'desc')->paginate(30);

								break;

							case 'year':

								$fromDate = Carbon::now()->subDays(366)->format('Y-m-d');

								$tillDate = Carbon::now()->format('Y-m-d');

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->whereBetween( DB::raw('date(created_at)'), [$fromDate, $tillDate] )->orderBy('id', 'desc')->paginate(30);

								break;

							

							default:

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->orderBy('id', 'desc')->paginate(30);

								break;

						}



					}elseif ($status) {

						

						switch ($status) {

							case 'featured':

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->where('is_featured', 1)->orderBy('id', 'desc')->paginate(30);

								break;

							case 'normal':

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->where('is_featured', 0)->orderBy('id', 'desc')->paginate(30);

								break;

							

							default:

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->orderBy('id', 'desc')->paginate(30);

								break;

						}



					}elseif ($condition) {

						

						switch ($condition) {

							case 'used':

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->where('is_used', 1)->orderBy('id', 'desc')->paginate(30);

								break;

							case 'new':

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->where('is_used', 0)->orderBy('id', 'desc')->paginate(30);

								break;

							

							default:

								$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->orderBy('id', 'desc')->paginate(30);

								break;

						}



					}else{



						// Get Ads

						$ads = Ad::where('category', $sub_category->id)->where('status', 1)->where('is_trashed', 0)->where('is_archived', 0)->orderBy('id', 'desc')->paginate(30);



					}



					// Get Stores

					$stores = DB::table('stores')->where('category', $sub_category->id)->where('status', 1)->orderByRaw('RAND()')->take(10)->get();



					// Send data

					$data = array(

						'ads'    => $ads, 

						'sub'    => $sub, 

						'parent' => $parent, 

						'stores' => $stores, 

					);



					// Get Tilte && Description

					$title      = Helper::settings_general()->title;

					$long_desc  = Helper::settings_seo()->description;

					$keywords   = Helper::settings_seo()->keywords;



					// Manage SEO

					SEO::setTitle($sub_category->category_name.' | '.$title);

			        SEO::setDescription($long_desc);

			        SEO::opengraph()->setUrl(Protocol::home().'/category/'.$parent.'/'.$sub);

			        SEOMeta::addKeyword([$keywords]);



					return view($this->theme.'.categories.category')->with($data);



				}else{

					// Not found

					return abort(404);

				}



			}else{


				// Get Parent category sub categories

				$sub_categories = Category::where('parent_category', $parent_category->id)->where('is_sub', 1)->get();



				// Get latest ads

				$latest_ads     = Ad::where('status', 1)->where('is_archived', 0)->where('is_trashed', 0)->where('category', $parent_category->id)->orderBy('id', 'desc')->paginate(20);

				foreach ($latest_ads as &$value) {
					$date  = time();
					$time = strtotime($value->created_at);
					$diff = $date-$time;
					$days = floor($diff/(60*60*24));
					$hours = floor($diff/(60*60));
					$minu = floor($diff/(60));
					$month = floor($diff/(30*60*60*24));
					$value->user_name = User::select('first_name','last_name')->where('id', $value->user_id)->get();
					
					if ($month > 0) {
						$value->timeleft ="قبل ".$month." شهر";
					} elseif ($days > 0) {
					   $value->timeleft ="قبل ".$days." يوم";
						
					} elseif ($hours > 0) {
						$value->timeleft ="قبل ".$hours." ساعه";
					}elseif ($minu > 0) {
						$value->timeleft ="قبل ".$minu."دقيقه";
					}
				}


				// Get Tilte && Description

				$title      = Helper::settings_general()->title;

				$long_desc  = Helper::settings_seo()->description;

				$keywords   = Helper::settings_seo()->keywords;



				// Manage SEO

				SEO::setTitle($parent_category->category_name.' | '.$title);

		        SEO::setDescription($long_desc);

		        SEO::opengraph()->setUrl(Protocol::home().'/category/'.$parent);

		        SEOMeta::addKeyword([$keywords]);



				return view($this->theme.'.categories.parent')->with([

					'sub_categories'  => $sub_categories,

					'parent_category' => $parent_category,

					'latest_ads'      => $latest_ads,

				]);



			}



		}else{

			// Not found

			return abort(404);

		}

	}



}