<?php

namespace App\Policies;

use App\Models\Food\Food;
use App\Models\Restaurant\Restaurant;
use App\Models\User;

class FoodPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Restaurant $restaurant): bool
    {
        return $user->can('viewAny-foods') and $restaurant->id === $user->restaurant->id or $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restaurant $restaurant): bool
    {
        return $user->can('view-food') &&  $restaurant->id === $user->restaurant->id or $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Restaurant $restaurant): bool
    {
        return $user->can('create-food') &&  $restaurant->id === $user->restaurant->id  or $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restaurant $restaurant): bool
    {
        return $user->can('update-food') &&  $restaurant->id === $user->restaurant->id or $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Restaurant $restaurant): bool
    {
        return $user->can('delete-food') &&  $restaurant->id === $user->restaurant->id or $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function foodParty(User $user): bool
    {
        return $user->hasRole('admin');
    }

}
