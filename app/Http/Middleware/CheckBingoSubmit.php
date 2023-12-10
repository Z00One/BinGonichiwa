<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Game;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Services\RoomService;

class CheckBingoSubmit
{
    private $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::user()->id;
        $gameChannel = $request->route(config('broadcasting.game.channel'));
        $isGameOver = Game::where('channel', $gameChannel)?->first();

        if ($isGameOver !== null) {
            abort(410, config('broadcasting.game.GameOver'));
        }

        $channel = str_replace(config('broadcasting.game.game'), config('broadcasting.game.waiting'), $gameChannel);
        $players = Redis::hgetall($channel);

        if (!$this->roomService->isRoomMember($userId, $channel)) {
            abort(403);
        }

        $request->merge(['gameChannel' => $gameChannel, 'players' => array_values($players)]);
        return $next($request);
    }
}
