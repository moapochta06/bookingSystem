<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware('web')->group(function () {
    Route::get('/', [AppController::class, 'index'])->name('home');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class, 'store']);
    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout')
        ->middleware('auth');
});

