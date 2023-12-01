<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class CheckGameChannelAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::user()->id;
        $channelName = $request->route(config('broadcasting.game.channel'));
        $gameChannal = Redis::hgetall($channelName);

        if (!$gameChannal) {
            return view('errors.404');
        }

        if (count($gameChannal) < config('broadcasting.game.players')) {
            return view('errors.404');
        }

        foreach ($gameChannal as $user) {
            if ($user === (string) $userId) {
                $request->merge(['userId' => $userId, config('broadcasting.game.channel') => $channelName, 'gameChannel' => $gameChannal]);
                return $next($request);
            }
        }

        return view('errors.403');
    }
}
