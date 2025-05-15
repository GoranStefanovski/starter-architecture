<?php

namespace App\Applications\Common\Controllers;

use App\Http\Controllers\Controller;
use App\Applications\Common\Model\MusicGenre;
use App\Applications\Common\Model\VenueType;

class TaxonomyController extends Controller
{
    public function musicGenres()
    {
        return response()->json(
            MusicGenre::orderBy('order')->get(['id', 'name'])
        );
    }

    public function venueTypes()
    {
        return response()->json(
            VenueType::orderBy('order')->get(['id', 'name'])
        );
    }
}
