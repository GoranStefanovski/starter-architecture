<?php

use Illuminate\Http\Request;
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
        'prefix' => 'vacationday',
    ], function () {
        Route::get('all', [VacationDayController::class, 'getAll']);
        Route::get('draw', [VacationDayController::class, 'draw']);

        // CRUD ROUTES
        Route::post('create', [VacationDayController::class, 'create']);
        Route::get('{id}', [VacationDayController::class, 'get']);
        Route::patch('{id}', [VacationDayController::class, 'update']);
        Route::delete('{id}', [VacationDayController::class, 'delete']);
    });
});
