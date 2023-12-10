<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Redis;

Broadcast::channel(config('broadcasting.game.waiting') . '{channelName}', function ($userInfo, $channelName) {
    $userId = $userInfo->id;
    $channel = config('broadcasting.game.waiting') . $channelName;
    $waitingList = Redis::hgetall($channel);
    
    if (count($waitingList) <= config('broadcasting.game.players')) {
        return [
            'userId' => $userId,
        ];
    }

    return false;
});

Broadcast::channel(config('broadcasting.game.game') . '{channelName}', function ($userInfo, $channelName) {
    $userId = $userInfo->id;
    $channel = config('broadcasting.game.waiting') . $channelName;
    $waitingList = Redis::hgetall($channel);
    
    if (count($waitingList) <= config('broadcasting.game.players')) {
        foreach ($waitingList as $id) {
            if ($id === (string) $userId) {
                return [
                    'userId' => $userId,
                ];
            }
        }
    }

    return false;
});
