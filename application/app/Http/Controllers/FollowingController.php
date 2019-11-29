<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Follow;
use App\Notifications\NewFollower;
use Response;
use Auth;
use App\User;

class FollowingController extends Controller
{

    function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Follow store
     */
    public function follow(Request $request)
    {
    	// Check username
    	$username = $request->get('username');

    	$store = Store::where('username', $username)->where('status', 1)->first();

    	if (!$store) {
    		
    		// Store Not found
    		$response = array(
    			'status' => 'error', 
    			'msg'    => __('return/error.lang_store_not_found'), 
    		);

    		return Response::json($response);

    	}else{

    		// Get Current username
    		$currentUsername = Auth::user()->username;

    		// Check if already followed this store
    		$followed = Follow::where('store', $username)->where('followed_by', $currentUsername)->first();

    		if ($followed) {
    			
    			// Already followed that store
	    		$response = array(
	    			'status' => 'error', 
	    			'msg'    => __('update_two.lang_already_followed'), 
	    		);

	    		return Response::json($response);

    		}else{

    			// Can't follow your self
    			if (Auth::id() == $store->owner_id) {
    				
    				// Error
    				$response = array(
		    			'status' => 'error', 
		    			'msg'    => __('update_two.lang_cant_follow_yourself'), 
		    		);

		    		return Response::json($response);

    			}

    			// start following this store
				$follower              = new Follow;
				$follower->store       = $username;
				$follower->followed_by = $currentUsername;
				$follower->save();

    			// Send notification to store owner
    			$user = User::where('id', $store->owner_id)->first();
    			$user->notify(new NewFollower());

    			// Following success
	    		$response = array(
	    			'status' => 'success', 
	    			'msg'    => __('update_two.lang_following_success'), 
	    		);

	    		return Response::json($response);

    		}

    	}
    }
}
