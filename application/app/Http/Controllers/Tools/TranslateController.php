<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Translate;
use Response;
use Purifier;
use Validator;

/**
 * TranslateController
 */

class TranslateController extends Controller
{

	/**
	 * Translate Text
	 */
	public function translate(Request $request)
	{
		// Check if ajax Request
		if ($request->ajax()) {
			
			// Make Validation
			$rules = array(
				'langTo' => 'required|alpha|in:ar,en,fr,fi,ko,ja,it,ga,my,th,de,sv,sk,pl,no,nl,ro,ru,es,zh-CN,zh-TW,cs,hu,tr,id,uk,hi,tl,pt,vi,ta', 
				'text'   => 'required', 
			);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				// Return Response
				$response  = array(
					'status'  => 'error', 
					'msg'     => __('return/error.lang_something_went_wrong')
				);

				return Response::json($response);
			}

			// Get Target Language
			$langTo    = $request->get('langTo');

			// Get Text
			$text      = Purifier::clean($request->get('text'));

			// Translate Text
			$translate = new Translate(null, $langTo);

			$new       = $translate->translate($text);

			// Error
			if (!$new) {
				// Return Response
				$response  = array(
					'status'  => 'error', 
					'msg'     => __('return/error.lang_something_went_wrong')
				);

				return Response::json($response);
			}

			// Return Response
			$response  = array(
				'status'  => 'success', 
				'msg'     => nl2br($new),
			);

			return Response::json($response);

		}
	}

}