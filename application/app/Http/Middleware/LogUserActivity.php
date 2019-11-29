<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use Auth;
use Carbon\Carbon;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            
            $expired_at = Carbon::now()->addMinutes(10);

            Cache::put('user-online-'.Auth::id(), true, $expired_at);

        }
        return $next($request);
    }
}
