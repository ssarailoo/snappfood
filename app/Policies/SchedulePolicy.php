<?php

namespace App\Policies;

use App\Models\Restaurant\Restaurant;
use App\Models\Schedule\Schedule;
use App\Models\User;

class SchedulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Restaurant $restaurant): bool
    {
        return ($user->can('viewAny-schedules') and $user->restaurant == $restaurant)
            or $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Schedule $schedule): bool
    {
        return ($user->can('view-schedule') and $user->restaurant->schedules->find($schedule->id) == !null)
            or $user->hasRole('admin');
    }
  

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Restaurant $restaurant): bool
    {
        return ($user->can('create-schedule') and $user->restaurant == $restaurant)
            or $user->hasRole('admin');
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Schedule $schedule): bool
    {
        return ($user->can('update-schedule') and $user->restaurant->schedules->find($schedule->id) == !null)
            or $user->hasRole('admin');
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Schedule $schedule): bool
    {
        return ($user->can('delete-schedule') and $user->restaurant->schedules->find($schedule->id) == !null)
            or $user->hasRole('admin');
    }



}
