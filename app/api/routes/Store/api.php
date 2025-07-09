<?php

use Illuminate\Http\Request;
use App\Applications\Store\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| This file contains the API routes for the Store module
|
|
*/

// AUTHORIZED ROUTES
Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::group([
        'prefix' => 'store',
    ], function () {
        Route::get('all', [StoreController::class, 'getAll']);
        Route::get('draw', [StoreController::class, 'draw']);

        // CRUD ROUTES
        Route::post('create', [StoreController::class, 'create']);
        Route::get('{id}', [StoreController::class, 'get']);
        Route::patch('{id}', [StoreController::class, 'update']);
        Route::delete('{id}', [StoreController::class, 'delete']);

    });
});
