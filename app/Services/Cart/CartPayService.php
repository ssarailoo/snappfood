<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Models\Food\FoodParty;
use App\Models\User;

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
            return ['success' => true, 'msg' => 'Your cart has been paid successfully'];
        }
    }


}
