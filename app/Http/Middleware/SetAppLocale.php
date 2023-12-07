<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class SetAppLocale 
{
    /**
     * Handle an incoming request.
     *
     * This middleware manages the user's language preference. 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $locale = $request->route('lang');

        $supportedLanguages = config('app.supported_languages');

        if (in_array($locale, $supportedLanguages)) {
            Session::put('locale', $locale);
        } else {
            $locale = Session::get('locale', App::getLocale());
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
