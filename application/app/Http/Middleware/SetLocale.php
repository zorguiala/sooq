<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;
use Carbon\Carbon;

class SetLocale
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
        // Get available languages
        $available = array('az', 'ar', 'en', 'fr', 'fi', 'de', 'ct', 'cn', 'sk', 'se', 'it', 'id', 'th', 'es', 'br', 'cz', 'jp', 'kr', 'nl', 'pl', 'ro', 'ru', 'tr', 'vi', 'hu', 'uk', 'ph', 'in', 'my', 'ge');

        // Get Language
        $locale    = $request->get('lang');

        // Check if request new language
        if (isset($locale)) {
            
            // Check if language exists
            if (in_array($locale, $available)) {
                // Update Session
                Session::put('locale', $locale);

                if ($locale == 'ar') {
            
                    Config::set('app.rtl', true);

                }

                // Set Language
                App::setLocale($locale);

                // Change Carbon lang
                Carbon::setlocale($locale);

                // Return request
                return $next($request);
            }else{
                // Return request
                return $next($request);
            }
            
        }else{

            // Check if session exists
            if (Session::has('locale')) {

                $locale = Session::get('locale', Config::get('app.locale'));

                if ($locale == 'ar') {
            
                    Config::set('app.rtl', true);

                }

                // Set Language
                App::setLocale($locale);

                // Change Carbon lang
                Carbon::setlocale($locale);

                // Return request
                return $next($request);

            }else{

                // Set Language
                App::setLocale(config('app.locale'));

                // Change Carbon lang
                Carbon::setlocale(config('app.locale'));

                // Return request
                return $next($request);

            }

        }

    }
}
