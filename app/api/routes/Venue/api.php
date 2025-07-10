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
        Route::get('by-city/{city}', [VenueController::class, 'getByCityAndOwner']);
        //TODO: change to update/{id} for clarity, handle route for the frontend(dashboard) aswell
        Route::patch('{id}', [VenueController::class, 'update']);
        Route::post('delete/{id}', [VenueController::class, 'delete']);

        // Venue images
        Route::post('image/{id}', [VenueController::class, 'uploadVenueImage']);
        Route::delete('{venueId}/delete-image/{imageId}', [VenueController::class, 'deleteVenueImage']);
    });
});
