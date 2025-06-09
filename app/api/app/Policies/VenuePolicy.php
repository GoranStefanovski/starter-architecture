<?php

namespace App\Policies;

use App\Applications\User\Model\User;
use App\Applications\Venue\Model\Venue;
use Illuminate\Auth\Access\Response;

class VenuePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAllVenues(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function getAllVenuesForEvent(User $user): bool
    {
        return $user->hasRole('organization');
    }

    public function getOwnVenuesForEvent(User $user): bool
    {
        return $user->hasRole('collaborator');
    }

    /**
     * Determine whether the user can create models.
     */
//    public function create(User $user): bool
//    {
//        //
//    }

    /**
     * Determine whether the user can update the model.
     */
//    public function update(User $user, Venue $venue): bool
//    {
//        //
//    }

    /**
     * Determine whether the user can delete the model.
     */
//    public function delete(User $user, Venue $venue): bool
//    {
//        //
//    }

}
