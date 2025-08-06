<?php

use App\Applications\Event\Controllers\EventController;
use App\Constants\UserPermissions;
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

        //TODO: right now using the same controller api functions meant for the dashboard, should create new functions
        // that return only data that is meant for the mobile application

        // 🟢 Read Events for mobile
        Route::middleware('permission:' . UserPermissions::READ_EVENTS_PUBLIC)->group(function () {
            Route::get('public/all', [EventController::class, 'getAll']);
            Route::get('public/draw', [EventController::class, 'draw']);
            Route::get('public/get/{id}', [EventController::class, 'get']);
            Route::post('nearby', [EventController::class, 'nearByEvents']);
        });

        // Read Events ( dashboard )
        Route::middleware('permission:' . UserPermissions::READ_EVENTS)->group(function () {
            Route::get('all', [EventController::class, 'getAll']);
            Route::get('draw', [EventController::class, 'draw']);
            Route::get('get/{id}', [EventController::class, 'get']);
        });

        // Write Events ( dashboard )
        Route::middleware('permission:' . UserPermissions::WRITE_EVENTS)->group(function () {
            Route::post('create', [EventController::class, 'create']);
            Route::patch('update/{id}', [EventController::class, 'update']);
            Route::post('image/{id}', [EventController::class, 'uploadEventImage']);
        });

        // Delete Events ( dashboard )
        Route::middleware('permission:' . UserPermissions::DELETE_EVENTS)->group(function () {
            Route::post('delete/{id}', [EventController::class, 'delete']);
        });

        // Nearby Events ( dashboard )
        Route::middleware('permission:' . UserPermissions::READ_EVENTS)->group(function () {
            Route::post('nearby', [EventController::class, 'nearByEvents']);
        });
    });
});
