<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class CheckNewInstallation
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
        

        try {

            $conn = DB::connection()->getPdo();

            if ($conn) {
                // Already installed
                return $next($request);
            }
            
        } catch (\Exception $e) {
            
            // New install
            return redirect('install/verify');

        }
        
    }
}
