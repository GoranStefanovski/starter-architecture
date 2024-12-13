<?php

use App\Applications\VacationDay\Controllers\VacationDayController;
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
        'prefix' => 'vacationdays',
    ], function () {
        Route::get('all', [VacationDayController::class, 'getAll']);
    });
});
