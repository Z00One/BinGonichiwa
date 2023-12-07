<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use App\Events\WaitingEvent;
use Illuminate\Support\Facades\Auth;
use App\Services\BingoService;
use App\Events\BingoValueSubmitEvent;
use App\Events\BingoSubmitEvent;

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
                
                if ($room === null) {
                    Redis::hmset($channel, [$userId]);
                    // TODO: smembers 로 배열로 관리하는게 좋을듯 Redis::smembers($channel, [$userId]); - set 타입 이라 중복을 걱정하지 않아도 된다.
                    $findRoom = true;
                }
                
                $room = array_unique($room);

                if (count($room) < config('broadcasting.game.players')) {
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
                $channel = config('broadcasting.game.waiting') . now()->timestamp . bin2hex(random_bytes(5));
                Redis::sadd(config('broadcasting.game.channels'), $channel);
                Redis::hmset($channel, [$userId]);
            }

            broadcast(new WaitingEvent([
                config('broadcasting.game.channel') => $channel,
                ]));
        } 
        else {
            $channel = config('broadcasting.game.waiting') . now()->timestamp . bin2hex(random_bytes(5));
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
        $channel = request()->input(config('broadcasting.game.channel'));
        $room = Redis::hgetall($channel);
        
        foreach ($room as $user => $id) {
            if ($id === (string)$userId) {
                Redis::hdel($channel, $user);
                break;
            }
        }
        
        return redirect('/');
    }
    
    /**
     * Creates a new game session.
     *
     * @param Request $request The HTTP request object.
     * @param BingoService $bingoService The BingoService instance.
     * @return View The game view with the necessary data.
     */
    public function create(Request $request, BingoService $bingoService)
    {
        $userId = $request->userId;
        $channel = $request->channel;
        $waitingList = $request->waitingList;

        $opponentId = $waitingList[0] == (string) $userId ? (int) $waitingList[1] : (int) $waitingList[0];
        $opponent = User::find($opponentId)->name;
        
        $turn = $waitingList[0] == (string) $userId ? true : false;
        $bingoId = $turn ? 0 : 1;
        $opponentBingoId = $turn ? 1 : 0;
        
        $bingosId = str_replace(config('broadcasting.game.waiting'), config('broadcasting.game.game'), $channel);
        $bingoChannel = str_replace(config('broadcasting.game.waiting'), config('broadcasting.game.bingo', 'bingo.'), $channel);
        
        $bingos = Redis::get($bingosId);

        if($bingos === null) {
            $bingos = $bingoService->createBingoBoards();
            Redis::set($bingosId, json_encode($bingos));
        }
        else {
            $bingos = json_decode($bingos, true);
        }
        
        $channel = $bingosId;

        return view('game', compact('opponent', 'turn', 'bingos', 'bingoId', 'opponentBingoId', 'channel', 'userId', 'bingoChannel'));
    }

    /**
     * Submit the bingo value.
     *
     * @param Request $request The request object containing the channel and value.
     * @return \Illuminate\Http\JsonResponse The response containing the success message.
     */
    public function bingoValueSubmit(Request $request)
    {
        $channel = $request->channel;
        $value = (int) $request->value;

        broadcast(new BingoValueSubmitEvent([
            config('broadcasting.game.channel') => $channel,
            config('broadcasting.game.submitValue') => $value,
        ]));

        return response()->json(['message' => 'Submitted successfully'], 201);
    }

    /**
     * Store the submitted game data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with a success message.
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $players = $request->input('players');
        $opponentId = $players[0] == (string) $userId ? (int) $players[1] : (int) $players[0];
        $gameChannel = $request->input('gameChannel');
        $bingoChannel = str_replace(config('broadcasting.game.game'), config('broadcasting.game.bingo', 'bingo.'), $gameChannel);
        
        Game::create([
            'winner_id' => $userId,
            'loser_id' => $opponentId,
            'channel' => $gameChannel,
        ]);

        $bingosId = $request->input('bingosId');
        $channel = str_replace(config('broadcasting.game.game'), config('broadcasting.game.waiting'), $gameChannel);

        Redis::srem(config('broadcasting.game.channels'), $channel);
        Redis::del($channel);
        Redis::del($bingosId);
        
        broadcast(new BingoSubmitEvent([
            config('broadcasting.game.channel') => $bingoChannel,
            config('broadcasting.game.winnerId') => $userId,
        ]));

        return response()->json(['message' => 'Submitted successfully'], 201);
    }

    /**
     * Retrieves the record of a user.
     *
     * @param Request $request The HTTP request object.
     * @return View The view containing the user's record.
     */
    public function record(Request $request)
    {
        $user = $request->user;
        $userId = $user->id;
        
        $winCount = $user->wins()->count();
        $loseCount = $user->loses()->count();
        $allGames = Game::where('winner_id', $userId)->orWhere('loser_id', $userId);
        
        $winningRate = $allGames->get() 
        ? $winCount / ($allGames->count()) * 100
        : 0;
        
        $winningRate = number_format($winningRate, 2);
        
        $records= $allGames->orderBy('created_at', 'desc')->paginate(5);
        
        foreach ($records as $game) {
            $game->isWin = ($game->winner_id === $userId);
            $opponent = ($game->isWin) 
                ? ($game->loser()->first()?->name)
                : ($game->winner()->first()?->name);
            $game->opponent = $opponent;
        }

        return view('records', compact('user', 'records', 'winCount', 'loseCount', 'winningRate'));
    }
}
