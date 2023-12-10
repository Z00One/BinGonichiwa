<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class RoomService
{
    /**
     * Find a waiting room for the user.
     *
     * @return string The channel of the waiting room if found, otherwise create a new waiting room for the user.
     */
    public function findWaitingRoom(): string
    {
        $userId = Auth::user()->id;
        $channels = Redis::smembers(config('broadcasting.game.channels'));
        $channel = '';
        $findRoom = false;

        for ($i = 0; $i < count($channels) && !$findRoom; $i++) {
            $channel = $channels[$i];
            $room = Redis::hgetall($channel);

            if ($room == null) {
                Redis::hmset($channel, [$userId]);
                $findRoom = true;
            } else {
                $room = array_unique($room);
                if (count($room) < config('broadcasting.game.players')) {
                    array_push($room, $userId);
                    Redis::hmset($channel, $room);
                    $findRoom = true;
                } else {
                    foreach ($room as $id) {
                        if ($id === (string)$userId) {
                            $findRoom = true;
                        }
                    }
                }
            }
        }

        return $findRoom ? $channel : $this->createWaitingRoom($userId);
    }

    /**
     * Creates a waiting room for the specified user.
     *
     * @param int $userId The ID of the user.
     * @return string The generated channel for the waiting room.
     */
    private function createWaitingRoom(Int $userId): string
    {
        $channel = config('broadcasting.game.waiting') . now()->timestamp . bin2hex(random_bytes(5));
        Redis::sadd(config('broadcasting.game.channels'), $channel);
        Redis::hmset($channel, [$userId]);

        return $channel;
    }

    /**
     * Leave the waiting room for a specific channel.
     *
     * @param string $channel The channel to leave the waiting room for.
     * @return void
     */
    public function leaveWaitingRoom(String $channel): void
    {
        $userId = Auth::user()->id;
        $room = Redis::hgetall($channel);
        
        foreach ($room as $user => $id) {
            if ($id === (string)$userId) {
                Redis::hdel($channel, $user);
                break;
            }
        }
    }

    
    /**
     * Create a game room.
     *
     * @param String $channel The channel of the game room.
     * @param BingoService $bingoService The BingoService instance.
     * @return array An array containing the game room details.
     */
    public function createGameRoom(String $channel, BingoService $bingoService): array
    {
        $bingosId = str_replace(config('broadcasting.game.waiting'), config('broadcasting.game.game'), $channel);
        $bingoChannel = str_replace(config('broadcasting.game.waiting'), config('broadcasting.game.bingo'), $channel);
        
        $bingos = Redis::get($bingosId);

        if($bingos === null) {
            $bingos = $bingoService->createBingoBoards();
            Redis::set($bingosId, json_encode($bingos));
        }
        else {
            $bingos = json_decode($bingos, true);
        }

        $gameChannel = $bingosId;

        return ['bingosId' => $bingosId, 'gameChannel' => $gameChannel, 'bingos' => $bingos, 'bingoChannel' => $bingoChannel];
    }

    /**
     * Remove channel and bingos.
     *
     * @param string $channel The channel of the room.
     * @return void
     */
    public function leaveGameRoom(String $channel): void
    {
        $bingosId = str_replace(config('broadcasting.game.waiting'), config('broadcasting.game.game'), $channel);

        // 채널 삭제
        Redis::del($channel);
        Redis::srem(config('broadcasting.game.channels'), $channel);
        
        // 빙고 삭제
        Redis::del($bingosId);
    }

    /**
     * Checks if a user is a member of a room.
     *
     * @param int $userId The ID of the user.
     * @param string $channel The name of the room.
     * @return bool Returns true if the user is a member of the room, false otherwise.
     */
    public function isRoomMember(Int $userId, String $channel): bool
    {
        $members = Redis::hgetall($channel);

        foreach ($members as $id) {
            if ($id === (string) $userId) {
                return true;
            }
        }

        return false;
    }
}
