<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use App\Events\WaitingEvent;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Retrieves the channel list and assigns a user to a room.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 채널 리스트 가져오기
        $channels = Redis::smembers(config('broadcasting.game.channels'));
        $userId = Auth::user()->id;
        $channel = '';

        if (count($channels)) {
            $findRoom = false;
            
            for ($i = 0; $i < count($channels) && !$findRoom; $i++) {
                $channel = $channels[$i];
                $room = Redis::hgetall($channel);
                
                if ($room == null) {
                    Redis::hmset($channel, [$userId]);
                    $findRoom = true;
                }
                
                elseif (count($room) < 2) {
                    array_push($room, $userId);
                    Redis::hmset($channel, $room);
                    $findRoom = true;
                }

                else {
                    foreach ($room as $id) {
                        if ($id === (string)$userId) {
                            $findRoom = true;
                        }
                    }
                }
            }

            if (!$findRoom) {
                $channel = config('broadcasting.game.game') . bin2hex(random_bytes(5));
                Redis::sadd(config('broadcasting.game.channels'), $channel);
                Redis::hmset($channel, [$userId]);
            }

            broadcast(new WaitingEvent([
                'channel' => $channel,
                ]));
        } 
        else {
            $channel = config('broadcasting.game.game') . bin2hex(random_bytes(5));
            Redis::sadd(config('broadcasting.game.channels'), $channel);
            Redis::hmset($channel, [$userId]);
        }

        return view('waiting', [
            'channel' => $channel,
            ]);
    }

    /**
     * Leave the channel.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leave()
    {
        $userId = Auth::user()->id;
        $channelName = request()->input('channel');
        $channel = Redis::hgetall($channelName);
        
        foreach ($channel as $user => $id) {
            if ($id === (string)$userId) {
                Redis::hdel($channelName, $user);
                break;
            }
        }
        
        return redirect('/');
    }
    
    /**
     * Show the form for creating the resource.
     */
    public function create(String $channel)
    {

    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request): never
    {
        abort(404);
    }

    /**
     * Retrieves the records of a user based on their name.
     *
     * @param string $name The name of the user.
     * @return \Illuminate\View\View The view displaying the user's records.
     */
    public function record(String $name)
    {
        $user = User::where('name', $name)->first();
        
        if (!$user) {
            return view('errors.404');
        }

        $combinedGamesQuery = Game::where('winner_id', $user->id)
        ->orWhere('loser_id', $user->id);

        $latestGames = $combinedGamesQuery->orderByDesc('created_at')->paginate(5);

        foreach ($latestGames as $game) {
            $isWin = $game->winner_id == $user->id;
            $game->isWin = $isWin;
            $opponent = $isWin ? $game->loser()->first()?->name : $game->winner()->first()?->name;
            $game->opponent = $opponent;
        }

        $winCount = $user->wins()->count();
        $loseCount = $user->loses()->count();

        $winningRate = ($winCount + $loseCount) 
            ? ($winCount / ($winCount + $loseCount)) * 100
            : 0;
        $winningRate = number_format($winningRate, 2);

        return view('records', [
           'records' => $latestGames,
           'name' => $name,
           'user' => [
               'winCount' => $winCount,
               'loseCount' => $loseCount,
               'winningRate' => $winningRate,
           ],
        ]);
    }
}
