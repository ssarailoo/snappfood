<?php

namespace App\Services;

use App\Models\Cart\Cart;
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
            return ['msg' => 'Your cart has been paid successfully'];
        }
    }
}
