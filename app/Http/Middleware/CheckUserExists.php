<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckUserExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $name = $request->route('name');
        $user = User::where('name', $name)->first();

        $isUser = $user ? true : false;

        $request->merge(['user' => $user, 'isUser' => $isUser]);

        return $next($request);
    }
}
