<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/set-language/{lang}', function ($lang) {
    if (! in_array($lang, ['en', 'ja'])) {
        abort(400);
    }

    Session::put('locale', $lang);
    
    return redirect()->back();
});

Route::get('records/{name}', [GameController::class, 'record']);