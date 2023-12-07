<?php

namespace App\Policies;


use App\Enums\OrderStauts;
use App\Models\Order;
use App\Models\Restaurant\Restaurant;
use App\Models\User;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or $user->restaurant->is($restaurant)  ;
    }

    public function view(User $user,Order $order, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or ($user->restaurant->is($restaurant) and $user->restaurant->orders->contains($order))  ;
    }

    public function update(User $user, Order $order, $newStatus)
    {
        if (!$user->restaurant->orders->contains($order)) {
            return false;
        }
        $currentStatus = $order->status;
        $allowedTransitions = [
            OrderStauts::CHECKING->value => [OrderStauts::CANCELED->value, OrderStauts::PREPARING->value],
            OrderStauts::PREPARING->value => [OrderStauts::SHIPPING->value],
            OrderStauts::SHIPPING->value => [OrderStauts::DELIVERED->value],
        ];
        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return false;
        }

        return true;
    }

}
