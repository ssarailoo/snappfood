<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use Illuminate\Http\Request;

class CartTotalService
{
    public function updateTotal(Cart $cart)
    {

        $cartFoods = $cart->cartFoods;

            $total = $cartFoods->reduce(function ($carry, $cartFood) {
                $food = Food::query()->find($cartFood->food_id);
                $count = $cartFood->food_count;
                $pricePerItem = $cartFood->price * (100 - $cartFood->discount_percent) / 100;
                return $carry + ($pricePerItem * $count);
            }, 0);


        $cart->update([
            'total' => $total
        ]);
    }
}
