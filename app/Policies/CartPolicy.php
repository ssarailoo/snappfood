<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\Cart\Cart;
use App\Models\User;

class CartPolicy
{

    public function isCartBelongingToUser(User $user, Cart $cart): bool
    {
        return $user->carts->contains($cart);
    }

    public function update(User $user,Cart $cart ,$newStatus)
    {
        if (!$user->restaurant->carts->contains($cart)) {
            return false;
        }
        $currentStatus = $cart->status;
        $allowedTransitions = [
            Status::CHECKING->value => [Status::CANCELED->value, Status::PREPARING->value],
            Status::PREPARING->value => [Status::SHIPPING->value],
            Status::SHIPPING->value => [Status::DELIVERED->value],
        ];
        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return false;
        }

        return true;
    }


}
