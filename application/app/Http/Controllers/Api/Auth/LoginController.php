<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use App\User;
use Validator;
use Auth;
use Hash;
use DB;

class LoginController extends Controller
{

    use IssueTokenTrait;
    
    private $client;

    public function __construct()
    {

        $this->client = Client::where('id', 2)->first();

    }

    /**
     * post login
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login(Request $request)
    {

        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Get user data
        $user = User::where('email', request('email'))->first();

        if ( $user && ( Hash::check(request('password'), $user->password) && !$user->status ) ) {
            
            // User nor active
            $response = array(
                'status'  => false, 
                'message' => 'Oops! Your account is not active. Please try again later.', 
            );

            return response()->json($response, 204, []);

        }

        return $this->issueToken($request, 'password');

    }

    /**
     * Refresh token
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function refresh(Request $request)
    {

        $this->validate($request, [
            'refresh_token' => 'required'
        ]);

        return $this->issueToken($request, 'refresh_token');

    }

    /**
     * Logout page
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function logout(Request $request)
    {

        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();

        return response()->json([], 204);

    }

}
