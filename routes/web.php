<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/waiting', [GameController::class, 'index']);
    Route::patch('waiting/leave', [GameController::class, 'leave']);
    Route::get('/games/{channel}', [GameController::class, 'create']);
});


Route::get('/set-language/{lang}', function ($lang) {
    if (! in_array($lang, ['en', 'ja'])) {
        abort(400);
    }
    
    Session::put('locale', $lang);
    
    return redirect()->back();
});

Route::get('records/{name}', [GameController::class, 'record']);

