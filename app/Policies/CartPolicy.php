<?php

namespace App\Policies;

use App\Enums\CartStatus;
use App\Models\Cart\Cart;
use App\Models\Restaurant\Restaurant;
use App\Models\User;

class CartPolicy
{

    public function isCartBelongingToUser(User $user, Cart $cart): bool
    {
        return $user->carts->contains($cart);
    }



}
