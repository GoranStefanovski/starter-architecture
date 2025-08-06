<?php

use App\Constants\UserPermissions;
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
        //TODO: right now using the same controller api functions meant for the dashboard, should create new functions
        // that return only data that is meant for the mobile application

        // Read Venues for mobile
        Route::middleware('permission:' . UserPermissions::READ_VENUES_PUBLIC)->group(function () {
            Route::get('public/all', [VenueController::class, 'getAll']);
            Route::get('public/draw', [VenueController::class, 'draw']);
            Route::get('public/get/{id}', [VenueController::class, 'get']);
            Route::get('by-city/{city}', [VenueController::class, 'getByCityAndOwner']);
        });

        // Read routes ( dashboard )
        Route::middleware('permission:' . UserPermissions::READ_VENUES)->group(function () {
            Route::get('all', [VenueController::class, 'getAll']);
            Route::get('draw', [VenueController::class, 'draw']);
            Route::get('get/{id}', [VenueController::class, 'get']);
            Route::get('by-city/{city}', [VenueController::class, 'getByCityAndOwner']);
        });

        // Write routes ( dashboard )
        Route::middleware('permission:' . UserPermissions::WRITE_VENUES)->group(function () {
            Route::post('create', [VenueController::class, 'create']);
            Route::patch('{id}', [VenueController::class, 'update']);
            Route::post('image/{id}', [VenueController::class, 'uploadVenueImage']);
            Route::delete('{venueId}/delete-image/{imageId}', [VenueController::class, 'deleteVenueImage']);
        });

        // Delete routes ( dashboard )
        Route::middleware('permission:' . UserPermissions::DELETE_VENUES)->group(function () {
            Route::post('delete/{id}', [VenueController::class, 'delete']);
        });
    });
});
