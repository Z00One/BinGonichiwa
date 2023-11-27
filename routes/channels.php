<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel(config('broadcasting.game.game') . '{roomId}', function ($roomId) {
    return [
        'userId' => Auth::user()->id,
        'roomId' => $roomId
    ];
    
    return false; // 사용자가 인증되지 않았거나 채널에 참여할 수 없는 경우 false를 반환합니다.
});