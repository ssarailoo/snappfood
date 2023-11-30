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

    public function viewAny(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or $user->restaurant->is($restaurant)  ;
    }

    public function view(User $user,Cart $cart, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or ($user->restaurant->is($restaurant) and $user->restaurant->carts->contains($cart))  ;
    }

    public function update(User $user, Cart $cart, $newStatus)
    {
        if (!$user->restaurant->carts->contains($cart)) {
            return false;
        }
        $currentStatus = $cart->status;
        $allowedTransitions = [
            CartStatus::CHECKING->value => [CartStatus::CANCELED->value, CartStatus::PREPARING->value],
            CartStatus::PREPARING->value => [CartStatus::SHIPPING->value],
            CartStatus::SHIPPING->value => [CartStatus::DELIVERED->value],
        ];
        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return false;
        }

        return true;
    }


}
