<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class CheckBingoAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::user()->id;
        $channelName = $request->route('bingosName');
        
        $bingosName = str_replace(config('broadcasting.game.game'),config('broadcasting.game.bingos'), $channelName);
        $channel = Redis::hgetall($channelName);
        
        $isBingosPlayer = false;
        
        foreach ($channel as $id) {
            if ($id === (string) $userId) {
                $isBingosPlayer = true;
                break;
            }
        }
        
        if (!$isBingosPlayer) {
            abort(403);
        }
        
        $bingos = Redis::get($bingosName);
        
        if (!$bingos) {
            return view('errors.404');
            abort(404);
        }
        
        $bingoId = $request->input('bingoId') ?? "none";
        
        if ($bingoId === "none" || (int)$bingoId < 0 || (int)$bingoId > config('broadcasting.game.players')) {
            abort(404);
        }

        $request->merge(['bingos' => $bingos, config('broadcasting.game.channel') => $channelName]);

        return $next($request);
    }
}
