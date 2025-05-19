<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EstateObjectController;


Route::middleware('web')->group(function () {
    Route::get('/', [AppController::class, 'index'])->name('home');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class, 'store']);
    Route::post('/logout', [LoginController::class, 'destroy'])
        // ->name('logout')
        ->middleware('auth');
    Route::get('/objects', [EstateObjectController::class, 'get_estateObjects']);
    Route::post('/create-object', [EstateObjectController::class, 'store']);
    Route::get('/admin/create/estate', [EstateObjectController::class, 'get_form']);
    Route::get('/admin/estate/{id}/edit', [EstateObjectController::class, 'edit']);
    Route::post('/admin/estate/{id}', [EstateObjectController::class, 'update']);
    Route::delete('/admin/estate/{id}', [EstateObjectController::class, 'destroy']);
});

