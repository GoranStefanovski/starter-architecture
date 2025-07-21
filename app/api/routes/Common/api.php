<?php

use Illuminate\Http\Request;
use App\Applications\Common\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| This file contains the API routes for the User module
|
|
*/

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'getAll']);
    Route::get('/{id}', [CategoryController::class, 'get']);
    Route::get('draw', [CategoryController::class, 'draw']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CategoryController::class, 'create']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'delete']);
    });
});