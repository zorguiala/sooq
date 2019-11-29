<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Ad;
use App\Models\Store;
use Auth;
use Validator;
use Carbon\Carbon;
use Helper;
use SEO;
use Protocol;
use SEOMeta;
use Theme;

class StoreController extends Controller
{
    public $theme = '';
    
    function __construct()
    {
        $this->theme = Theme::get();
    }

    /*********** Show Stores ***********/
    public function stores()
    {
        // Get Stores
        $stores = Store::where('status', 1)->orderByRaw('RAND()')->paginate(30);

        // Get Tilte && Description
        $title      = Helper::settings_general()->title;
        $long_desc  = Helper::settings_seo()->description;
        $keywords   = Helper::settings_seo()->keywords;

        // Manage SEO
        SEO::setTitle(__('title.lang_stores').' | '.$title);
        SEO::setDescription($long_desc);
        SEO::opengraph()->setUrl(Protocol::home());
        SEOMeta::addKeyword([$keywords]);

        return view($this->theme.'.stores.browse')->with('stores', $stores);
    }

    /**
     * Show Store
     */
    public function store(Request $request, $store)
    {
        
        // check store
        $store = Store::where('username', $store)->first();

        if ($store) {

            // Check store status
            if (!$store->status) {
                
                if (Auth::check()) {
                    
                    if ( (Auth::id() != $store->owner_id) && (!Auth::user()->is_admin) ) {
                        // Not found
                        return redirect('/')->with('error', __('return/error.lang_store_not_found'));
                    }

                }else{
                    // Not found
                    return redirect('/')->with('error', __('return/error.lang_store_not_found'));
                }

            }

            // Get Store Ads
            $ads = Ad::where('user_id', $store->owner_id)->where('status', 1)->where('is_archived', 0)->where('is_trashed', 0)->orderBy('id', 'desc')->paginate(20);

            // Send Data
            $data = array(
                'store' => $store, 
                'ads'   => $ads, 
            );

            // Get Tilte && Description
            $keywords        = Helper::settings_seo()->keywords;
            
            // Create Seo Description
            $seo_description = substr(trim(preg_replace('/\s+/', ' ', $store->long_desc)), 0, 150);

            // Manage SEO
            SEO::setTitle($store->title.' | '.$store->short_desc);
            SEO::setDescription($seo_description);
            SEO::opengraph()->setUrl(Protocol::home().'/store/'.$store->username);
            SEOMeta::addKeyword([$keywords]);

            return view(Theme::get().'.stores.store')->with($data);
            
        }else{

            // Not found
            return redirect('/')->with('error', __('return/error.lang_store_not_found'));

        }

    }

}
