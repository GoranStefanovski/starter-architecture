<?php

use App\Applications\Event\Controllers\EventController;
use Illuminate\Http\Request;
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
        'prefix' => 'event',
    ], function () {
        Route::get('all', [EventController::class, 'getAll']);
        Route::get('draw', [EventController::class, 'draw']);

        // CRUD ROUTES
        Route::post('create', [EventController::class, 'create']);
        Route::get('get/{id}', [EventController::class, 'get']);
        //TODO: might need to be changed to a POST method
        Route::patch('update/{id}', [EventController::class, 'update']);
        Route::delete('delete/{id}', [EventController::class, 'delete']);

        // User avatars
        Route::post('avatar/{id}', [EventController::class, 'uploadAvatar']);
    });
});
