<?php

namespace App\Http\Middleware;

use Closure;
use Schema;
use DB;
use Theme;

class MaintenanceMiddleware
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

            if (Schema::hasTable('settings_general')) {

                // Check maintenance mode
                $settings = DB::table('settings_general')->where('id', 1)->first();

                if ($settings->is_maintenance) {
                    
                    // Site is under maintenance
                    return redirect('maintenance');

                }else{

                    return $next($request);

                }

            }else{

                return $next($request);

            }
            
        } catch (\Exception $e) {
            return $next($request);
        }
        
    }
}
