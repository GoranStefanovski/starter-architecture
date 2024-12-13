<?php

use App\Applications\DayType\Controllers\DayTypeController;
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
        'prefix' => 'common',
    ], function () {
        Route::get('daytypes/all', [DayTypeController::class, 'getAll']);
    });
});
