<?php

namespace App\Http\Middleware;

use App\Constants\AppLocalesConstant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('X-Locale', 'en');

        if(!in_array($locale, AppLocalesConstant::toArray())) {
            $locale = 'en';
        }

        if(App::currentLocale() !== $locale) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
