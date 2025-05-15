<?php

use Illuminate\Support\Facades\Route;
use App\Applications\Common\Controllers\TaxonomyController;

Route::get('/taxonomies/music-genres', [TaxonomyController::class, 'musicGenres']);
Route::get('/taxonomies/venue-types', [TaxonomyController::class, 'venueTypes']);
