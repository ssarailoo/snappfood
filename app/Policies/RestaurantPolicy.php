<?php

namespace App\Policies;

use App\Models\Restaurant\Restaurant;
use App\Models\User;

class RestaurantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny-restaurants');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restaurant $restaurant): bool
    {
        return $user->can('view-restaurant');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return is_null($user->restaurant);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restaurant $restaurant): bool
    {
        return $user->id == $restaurant->user_id || $user->can('edit-restaurant');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Restaurant $restaurant): bool
    {
        return $user->id == $restaurant->user_id || $user->can('edit-restaurant');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Restaurant $restaurant): bool
    {
        return $user->can('restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Restaurant $restaurant): bool
    {
        return $user->can('force-delete');
    }
}
