<?php

namespace App\Policies;

use App\Models\Address\Address;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AddressPolicy
{
    /**
     * Create a new policy instance.
     */
    public function myAddress(User $user, Address $address)
    {
        return $user->addresses->contains($address) ? Response::allow() : Response::deny('This Address does not belong to you')->withStatus(403);
    }
}
