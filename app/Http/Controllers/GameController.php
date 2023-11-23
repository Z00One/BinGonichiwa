<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;

class GameController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function create(): never
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request): never
    {
        abort(404);
    }

    /**
     * Display the resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }

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
        $winningRate = ($winCount / ($winCount + $loseCount)) * 100;
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
