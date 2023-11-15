<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SetAppLocale
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
      $previousLocale = Session::get('locale');

      $locale = $previousLocale ?? request()->getPreferredLanguage(['ja', 'en']);

      app()->setLocale($locale);
      
      return $next($request);
    }
}