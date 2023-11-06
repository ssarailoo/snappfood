<?php

namespace App\Policies;

use App\Models\Cart\Cart;
use App\Models\User;

class CartPolicy
{

    public function isCartBelongingToUser(User $user, Cart $cart): bool
    {
        return $user->carts->contains($cart);
    }


}
