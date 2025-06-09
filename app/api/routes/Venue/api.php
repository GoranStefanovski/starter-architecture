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
        Route::get('get/{id}', [VenueController::class, 'get']);
        //TODO: change to update/{id} for clarity, handle route for the frontend(dashboard) aswell
        Route::patch('{id}', [VenueController::class, 'update']);
        Route::delete('delete/{id}', [VenueController::class, 'delete']);

        //TODO: need to create route for fetching specific venues, where creating or editing an Event
        //TODO: and use getVenuesAvailableForEvent in VenueRepository

        // User avatars
        Route::post('avatar/{id}', [VenueController::class, 'uploadAvatar']);
    });
});
