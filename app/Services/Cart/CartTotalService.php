<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use Illuminate\Http\Request;

class CartTotalService
{
    public function updateTotal(Request $request,Cart $cart)
    {

        $foods = $cart->foods;
        $count = $request->food_count;
        $total = $foods->reduce(function ($carry, $food) use ($count) {
            $pricePerItem = $food->price * (100 - $food->discount) / 100;
            return $carry + ($pricePerItem * $count);
        }, 0);
        $cart->update([
            'total' => $total
        ]);
    }
}
