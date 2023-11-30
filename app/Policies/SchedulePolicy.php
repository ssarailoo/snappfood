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
        return $user->hasRole('admin') or
            ($user->can('viewAny-schedules') and $user->restaurant->is($restaurant));

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Schedule $schedule,Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or
            ($user->can('view-schedule') and
                $user->restaurant->schedules->contains($schedule) and $user->restaurant->is($restaurant));
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or
            ($user->can('create-schedule'
                ) and  $user->restaurant->is($restaurant));

    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Schedule $schedule,Restaurant $restaurant): bool
    {
        return  $user->hasRole('admin') or
            ($user->can('update-schedule')
                and $user->restaurant->schedules->contains($schedule)) and $user->restaurant->is($restaurant);

    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Schedule $schedule,Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or
            ($user->can('delete-schedule')
                and $user->restaurant->schedules->contains($schedule)  and $user->restaurant->is($restaurant)); }



}
