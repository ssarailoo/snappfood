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
        return $user->hasRole('admin') or $user->can('viewAny-foods') and  $restaurant->is($user->restaurant)  ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin')or $user->can('view-food') &&   $restaurant->is($user->restaurant)  ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or $user->can('create-food') &&  $restaurant->is($user->restaurant)  ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or $user->can('update-food') &&   $restaurant->is($user->restaurant)  ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or $user->can('delete-food') &&  $restaurant->is($user->restaurant) ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function foodParty(User $user): bool
    {
        return $user->hasRole('admin');
    }

}
