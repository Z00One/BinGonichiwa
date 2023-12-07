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
        $waitingList = Redis::hgetall($channelName);

        if (!$waitingList) {
            abort(404);
        }

        if (count($waitingList) < config('broadcasting.game.players')) {
            abort(403);
        }

        foreach ($waitingList as $user) {
            if ($user === (string) $userId) {
                $request->merge(['userId' => $userId, config('broadcasting.game.channel') => $channelName, 'waitingList' => array_values($waitingList)]);
                return $next($request);
            }
        }

        abort(403);
    }
}
