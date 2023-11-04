<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;

class AddressPolicy
{
    /**
     * Create a new policy instance.
     */
    public function myAddress(User $user, Address $address): bool
    {
        return $user->addresses->contains($address);
    }
}
