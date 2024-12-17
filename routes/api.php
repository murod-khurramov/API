<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::post('/create', [UserController::class, 'store']);
        Route::put('/update/{id}', [UserController::class, 'update']);

        Route::middleware(['throttle:6,1'])->group(function () {
            Route::delete('/delete/{id}', [UserController::class, 'destroy']);
        });
    });
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::post('/postCreate', [PostController::class, 'store']);
Route::put('/postUpdate/{id}', [PostController::class, 'update']);
Route::delete('/postDelete/{id}', [PostController::class, 'destroy']);
