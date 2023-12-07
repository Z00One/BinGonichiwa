<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Game;
use Illuminate\Support\Facades\Redis;

class CheckBingoSubmit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $gameChannel = $request->route(config('broadcasting.game.channel'));
        $isGameOver = Game::where('channel', $gameChannel)?->first();

        if ($isGameOver !== null) {
            abort(410, config('broadcasting.game.GameOver'));
        }

        $bingosId = str_replace(config('broadcasting.game.game'), config('broadcasting.game.waiting'), $gameChannel);
        $players = Redis::hgetall($bingosId);

        $request->merge(['gameChannel' => $gameChannel, 'players' => $players, 'bingosId' => $bingosId]);
        return $next($request);
    }
}
