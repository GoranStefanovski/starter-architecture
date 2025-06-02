<?php

namespace App\Policies;

use App\Applications\User\Model\User;
use App\Applications\Venue\Model\Venue;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAllEvents(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
//    public function view(User $user, Venue $venue): bool
//    {
//        //
//    }

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
