<?php

namespace App\Applications\Common\Controllers;

use App\Constants\TicketType;
use App\Http\Controllers\Controller;
use App\Applications\Common\Model\MusicGenre;
use App\Applications\Common\Model\VenueType;
use App\Applications\Common\Model\PostSlot;
use Illuminate\Http\Request;

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

    public function ticketTypes()
    {
        return response()->json([
            'types' => TicketType::TYPES
        ]);
    }

    public function postSlots() {
        return PostSlot::all();
    }

    public function createPostSlot(Request $request)
    {
        $data = $request->all();
        $postSlot = new PostSlot($data);
        $postSlot->save();

        return response()->json($postSlot);
    }

    public function updatePostSlot(Request $request, $id)
    {
        $data = $request->all();
        $postSlot = PostSlot::findOrFail($id);
        $postSlot->fill($data);
        $postSlot->save();

        return response()->json($postSlot);
    }


    public function getPostSlot($id) {
        return response()->json(
            PostSlot::findOrFail($id)
        );
    }

}
