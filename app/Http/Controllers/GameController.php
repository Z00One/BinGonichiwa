<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use App\Events\WaitingEvent;
use Illuminate\Support\Facades\Auth;
use App\Services\BingoService;
use App\Services\RoomService;
use App\Events\BingoValueSubmitEvent;
use App\Events\BingoSubmitEvent;

class GameController extends Controller
{
    /**
     * Retrieves the channel list and assigns a user to a room.
     * 
     * @param RoomService $roomService The room service for managing rooms.
     * @return \Illuminate\View\View
     */
    public function index(RoomService $roomService)
    {
        $channel = $roomService->findWaitingRoom();

        broadcast(new WaitingEvent([
            config('broadcasting.game.channel') => $channel,
        ]));

        return view('waiting', [
            config('broadcasting.game.channel') => $channel,
        ]);
    }

    /**
     * Leave the channel.
     *
     * @param RoomService $roomService The room service for managing rooms.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leave(Request $request, RoomService $roomService)
    {
        $channel = $request->channel;

        $roomService->leaveWaitingRoom($channel);
        
        return redirect('/');
    }
    
    /**
     * Creates a new game session.
     *
     * @param Request $request The HTTP request object.
     * @param RoomService $roomService The room service for managing rooms.
     * @param BingoService $bingoService The BingoService instance.
     * @return View The game view with the necessary data.
     */
    public function create(Request $request, RoomService $roomService, BingoService $bingoService)
    {
        $userId = $request->userId;
        $channel = $request->channel;
        $waitingList = $request->waitingList;

        $opponentId = $waitingList[0] == (string) $userId ? (int) $waitingList[1] : (int) $waitingList[0];
        $opponent = User::find($opponentId)->name;
        
        $turn = $waitingList[0] == (string) $userId ? true : false;
        $bingoId = $turn ? 0 : 1;
        $opponentBingoId = $turn ? 1 : 0;
        
        $gameRoom = $roomService->createGameRoom($channel, $bingoService);
        $bingos = $gameRoom['bingos'];
        $gameChannel = $gameRoom['gameChannel'];
        $bingoChannel = $gameRoom['bingoChannel'];

        return view('game', compact('opponent', 'turn', 'bingos', 'bingoId', 'opponentBingoId', 'gameChannel', 'userId', 'bingoChannel'));
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
     * Store the game result and submits a bingo event.
     *
     * @param Request $request The request object containing the game data.
     * @param RoomService $roomService The room service for managing rooms.
     * @return JsonResponse A JSON response indicating the success of the submission.
     */
    public function store(Request $request, RoomService $roomService)
    {
        $userId = Auth::user()->id;
        $players = $request->players;
        $opponentId = $players[0] == (string) $userId ? (int) $players[1] : (int) $players[0];
        $gameChannel = $request->gameChannel;
        $bingoChannel = str_replace(config('broadcasting.game.game'), config('broadcasting.game.bingo'), $gameChannel);
        
        Game::create([
            'winner_id' => $userId,
            'loser_id' => $opponentId,
            'channel' => $gameChannel,
        ]);

        $channel = str_replace(config('broadcasting.game.game'), config('broadcasting.game.waiting'), $gameChannel);
        $roomService->leaveGameRoom($channel);
        
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
        
        $winningRate = $allGames->count()
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
