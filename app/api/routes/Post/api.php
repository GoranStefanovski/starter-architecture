<?php

use App\Applications\Post\Controllers\PostController;
use App\Constants\UserPermissions;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| This file contains the API routes for the User module
|
|
*/

// AUTHORIZED ROUTES
Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::group([
        'prefix' => 'post',
    ], function () {

        // 🟢 Read Events for mobile
        Route::middleware('permission:' . UserPermissions::READ_POSTS_PUBLIC)->group(function () {
            Route::get('public/all', [PostController::class, 'getAll']);
            Route::get('public/draw', [PostController::class, 'draw']);
            Route::get('public/get/{id}', [PostController::class, 'get']);
        });

        // Read Events ( dashboard )
        Route::middleware('permission:' . UserPermissions::READ_POSTS)->group(function () {
            Route::get('all', [PostController::class, 'getAll']);
            Route::get('draw', [PostController::class, 'draw']);
            Route::get('get/{id}', [PostController::class, 'get']);
        });

        // Write Events ( dashboard )
        Route::middleware('permission:' . UserPermissions::WRITE_POSTS)->group(function () {
            Route::post('create', [PostController::class, 'create']);
            Route::patch('update/{id}', [PostController::class, 'update']);
            Route::post('image/{id}', [PostController::class, 'uploadPostImage']);
        });

        // Delete Events ( dashboard )
        Route::middleware('permission:' . UserPermissions::DELETE_POSTS)->group(function () {
            Route::post('delete/{id}', [PostController::class, 'delete']);
        });
    });
});
