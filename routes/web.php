<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EstateObjectController;
use App\Http\Controllers\SearchController;

Route::middleware('web')->group(function () {
    Route::get('/', [AppController::class, 'index'])->name('home');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/search-results', [SearchController::class, 'results']);
    Route::get('/objects/estate/{id}', [EstateObjectController::class, 'get_estate']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'destroy']);
        Route::post('/bookings', [BookingController::class, 'store']);
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/create-object', [EstateObjectController::class, 'store']);
        Route::get('/objects', [EstateObjectController::class, 'get_estateObjects']);
        Route::get('/admin/create/estate', [EstateObjectController::class, 'get_form']);
        Route::get('/admin/estate/{id}/edit', [EstateObjectController::class, 'edit']);
        Route::post('/admin/estate/{id}', [EstateObjectController::class, 'update']);
        Route::delete('/admin/estate/{id}', [EstateObjectController::class, 'destroy']);
    });
});


