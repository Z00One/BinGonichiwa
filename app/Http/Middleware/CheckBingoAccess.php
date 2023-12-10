<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Services\RoomService;

class CheckBingoAccess
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
        $channel = $request->route(config('broadcasting.game.channel'));
        $waitingChannel = str_replace(config('broadcasting.game.game'), config('broadcasting.game.waiting'), $channel);

        if (!$this->roomService->isRoomMember($userId, $waitingChannel)) {
            abort(403);
        }
        
        $bingos = Redis::get($channel);
        
        if (!$bingos) {
            abort(404);
        }
        
        $bingoId = $request->input('bingoId') ?? "none";
        
        if ($bingoId === "none" || (int)$bingoId < 0 || (int)$bingoId > config('broadcasting.game.players')) {
            abort(404);
        }

        $request->merge([config('broadcasting.game.channel') => $channel]);

        return $next($request);
    }
}
