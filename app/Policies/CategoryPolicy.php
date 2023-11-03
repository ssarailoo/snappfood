<?php

namespace App\Policies;

use App\Models\Restaurant\RestaurantCategory;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return  $user->can('viewAny-categories');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return  $user->can('view-category');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->can('create-category');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return  $user->can('update-category');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return  $user->can('delete-category');
    }

    /**
     * Determine whether the user can restore the model.
     */

}
