<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

Broadcast::channel(config('broadcasting.game.waiting') . '{channelName}', function ($channelName) {
    $userId = Auth::user()->id;
    $waitingChannal = Redis::hgetall($channelName);
    
    if (count($waitingChannal) < config('broadcasting.game.players')) {
        return [
            'userId' => $userId,
        ];
    }

    return false;
});

Broadcast::channel(config('broadcasting.game.game') . '{channelName}', function ($channelName) {
    $userId = Auth::user()->id;
    $waitingList = Redis::hgetall($channelName);
    return [
        'userId' => $userId,
        'waitingList' => $waitingList
    ];
    
    if (count($waitingList) < config('broadcasting.game.players')) {
        foreach ($waitingList as $user) {
            if ($user === (string) $userId) {
                return [
                    'userId' => $userId,
                ];
            }
        }
    }

    return false;
});