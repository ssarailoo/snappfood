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
        return (
                $user->can('viewAny-schedules')
                && $user->restaurant == $restaurant
            )
            || $user->can('edit-schedule');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Schedule $schedule): bool
    {
        return (
                $user->can('view-schedule') &&

                $user->restaurant->schedules->find($schedule->id) == !null
            )
            || $user->can('edit-schedule');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Restaurant $restaurant): bool
    {
        return ($user->can('create-schedule') &&
                $user->restaurant == $restaurant)
            || $user->can('edit-schedule');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Schedule $schedule): bool
    {
        return (
                $user->can('update-schedule') &&

                $user->restaurant->schedules->find($schedule->id) == !null
            )
            || $user->can('edit-schedule');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Schedule $schedule): bool
    {
        return (
                $user->can('delete-schedule') &&
                $user->restaurant->schedules->find($schedule->id) == !null
            )
            || $user->can('edit-schedule');
    }


}
