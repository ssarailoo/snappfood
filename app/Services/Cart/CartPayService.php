<?php

namespace App\Services\Cart;

use App\Enums\OrderStauts;
use App\Models\Cart\Cart;
use App\Models\Discount;
use App\Models\Food\FoodParty;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Discount\DiscountEmailNotification;
use Illuminate\Support\Facades\Auth;

class CartPayService
{
    public function payCart(Cart $cart, User $user)
    {


        $discount = Discount::query()->where('code', request()->input('code'))->first();
        if ($discount) {
            $cart->update([
                'discount_id' => $discount->id
            ]);
            $payment = $cart->total * (100 - $discount->percent) / 100;
            $cart->update(['is_paid' => 1]);
            $order = Order::query()->create([
                'user_id' => $cart->user_id,
                'restaurant_id' => $cart->restaurant_id,
                'total' => $cart->total,
                'discount_id' => $cart->discount_id,
                'status' => OrderStauts::CHECKING->value,
                'hashed_id' => $cart->hashed_id
            ]);
            $order->foods()->sync(
                $cart->getCartFoodsSyncData()
            );
            return ['success' => true, 'message' => "Your order has been registered.{$discount->percent} percent discount was applied. total payment {$payment} dollars"];
        }
        $cart->update(['is_paid' => 1]);

        $order = Order::query()->create([
            'user_id' => $cart->user_id,
            'restaurant_id' => $cart->restaurant_id,
            'total' => $cart->total,
            'status' => OrderStauts::CHECKING->value,
            'hashed_id' => $cart->hashed_id
        ]);
        $order->foods()->sync(
            $cart->getCartFoodsSyncData()
        );

        return ['success' => true, 'message' => 'Your order has been registered'];
    }


}
