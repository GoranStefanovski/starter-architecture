<?php

use Illuminate\Http\Request;
use App\Applications\Venue\Controllers\VenueController;
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
        'prefix' => 'venue',
    ], function () {
        Route::get('all', [VenueController::class, 'getAll']);
        Route::get('draw', [VenueController::class, 'draw']);

        // CRUD ROUTES
        Route::post('create', [VenueController::class, 'create']);
        Route::get('{id}', [VenueController::class, 'get']);
        Route::patch('{id}', [VenueController::class, 'update']);
        Route::delete('{id}', [VenueController::class, 'delete']);

        // User avatars
        Route::post('avatar/{id}', [VenueController::class, 'uploadAvatar']);
    });
});