<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware([\App\Http\Middleware\LogActivityMiddleware::class])->group(function () {
    Route::prefix('auth')->middleware('throttle:auth')->group(function () {
        Route::post('signup', [\App\Http\Controllers\AuthenticationController::class, 'signup']);
        Route::post('login', [\App\Http\Controllers\AuthenticationController::class, 'login']);
    });

    Route::middleware(['auth:api', 'throttle:api'])->prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::post('/create-post', [PostController::class, 'store']);
        Route::get('/view/{post}', [PostController::class, 'show']);
        Route::put('/update/{post}', [PostController::class, 'update']);
        Route::delete('/delete/{post}', [PostController::class, 'destroy']);
    });
//});
