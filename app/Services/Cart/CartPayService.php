<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Models\Discount;
use App\Models\Food\FoodParty;
use App\Models\User;
use App\Notifications\Discount\DiscountEmailNotification;

class CartPayService
{
    public function payCart(Cart $cart, User $user)
    {
        if ($user->current_address === null) {
            return ['msg' => 'Bad Request: First choose your current address'];
        } elseif ($cart->is_paid === 1) {
            return ['msg' => 'Bad Request: Already paid'];
        } else {
            $cart->update(['is_paid' => 1]);

            $cart->cartFoods->filter(fn($cartFood)=>$cartFood->in_party===1)->map(function ($cartFood){
                FoodParty::query()->where('food_id',$cartFood->food->id)->decrement('quantity',$cartFood->food_count);
            });
            $discount=Discount::query()->where('code',request()->input('code'))->first();
            if ($discount) {
                $cart->update([
                    'discount_id' => $discount->id
            ]);
                $payment=$cart->total* (100 - $discount->percent)/100;
                return ['success' => true, 'msg' => "Your cart has been paid successfully.{$discount->percent} percent discount was applied. total payment {$payment} dollars"];
            }
            return ['success' => true, 'msg' => 'Your cart has been paid successfully'];
        }
    }


}
