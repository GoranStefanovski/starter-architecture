<?php

use Illuminate\Support\Facades\Route;
use App\Applications\Common\Controllers\TaxonomyController;
use App\Constants\UserPermissions;

// Public routes
Route::get('/taxonomies/music-genres', [TaxonomyController::class, 'musicGenres']);
Route::get('/taxonomies/venue-types', [TaxonomyController::class, 'venueTypes']);
Route::get('/taxonomies/ticket-types', [TaxonomyController::class, 'ticketTypes']);
Route::get('/taxonomies/post_slots', [TaxonomyController::class, 'postSlots']);
Route::get('/taxonomies/post_slot/{id}', [TaxonomyController::class, 'getPostSlot']);

Route::group([
    'middleware' => 'auth:sanctum'
    ], function () {
    // Authorized routes for creating and updating post positions
    Route::middleware('permission:' . UserPermissions::WRITE_POSTS)->group(function () {
        Route::post('/taxonomies/post_slots/create', [TaxonomyController::class, 'createPostSlot']);
        Route::patch('/taxonomies/post_slots/update/{id}', [TaxonomyController::class, 'updatePostSlot']);
    });
});