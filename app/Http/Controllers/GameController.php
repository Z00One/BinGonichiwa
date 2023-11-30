<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use App\Events\WaitingEvent;
use Illuminate\Support\Facades\Auth;
use App\Services\BingoService;

class GameController extends Controller
{
    /**
     * Retrieves the channel list and assigns a user to a room.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
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
                
                elseif (count($room) < config('broadcasting.game.players')) {
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
                config('broadcasting.game.channel') => $channel,
                ]));
        } 
        else {
            $channel = config('broadcasting.game.game') . bin2hex(random_bytes(5));
            Redis::sadd(config('broadcasting.game.channels'), $channel);
            Redis::hmset($channel, [$userId]);
        }

        return view('waiting', [
            config('broadcasting.game.channel') => $channel,
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
        $channelName = request()->input(config('broadcasting.game.channel'));
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
    public function create(BingoService $bingoService, String $channel)
    {
        $userId = Auth::user()->id;

        $gameChannal = Redis::hgetall($channel);

        if (count($gameChannal) < config('broadcasting.game.players')) {
            return view('errors.404');
        }

        // TODO: 본 게임방에 없는 유저가 접근할 시 403 에러를 던져줄 필요가 있음
        $opponentId = $gameChannal[0] == (string) $userId ? (int) $gameChannal[1] : (int) $gameChannal[0];
        $opponent = User::find($opponentId)->name;
        
        $turn = $gameChannal[0] == (string) $userId ? true : false;
        $bingoId = $turn ? 0 : 1;
        $opponentBingoId = $turn ? 1 : 0;
        
        $bingosName = str_replace(config('broadcasting.game.game'), config('broadcasting.game.bingos'), $channel);
        
        $bingos = Redis::get($bingosName);

        if($bingos === null) {
            $bingos = $bingoService->createBingoBoards();
            Redis::set($bingosName, json_encode($bingos));
        }
        
        return view('game', compact('opponent', 'turn', 'bingos', 'bingoId', 'opponentBingoId', 'bingosName'));
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

        $userId = $user->id;
        
        $latestGames = Game::has('winner', $userId)->orHas('loser', $userId)->orderByDesc('created_at')->paginate(5);

        foreach ($latestGames as $game) {
            $isWin = $game->winner_id == $userId;
            $game->isWin = $isWin;
            $opponent = $isWin ? $game->loser()->first()?->name : $game->winner()->first()?->name;
            $game->opponent = $opponent;
        }

        $winCount = $user->wins()->count();

        $allGamesCount = Game::has('winner', $userId)->orHas('loser', $userId)->count();

        $winningRate = ($allGamesCount) 
            ? ($winCount / $allGamesCount) * 100
            : 0;
        
        $winningRate = number_format($winningRate, 2);
        
        return view('records', [
           'records' => $latestGames,
           'name' => $name,
           'user' => [
               'winCount' => $winCount,
               'winningRate' => $winningRate,
           ],
        ]);
    }
}
