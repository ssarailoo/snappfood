<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use Illuminate\Support\Facades\Auth;

class CartStoreService
{
    public function storeCart()
    {
        if (request()->has('food_party_id')) {
            $foodParty = FoodParty::query()->find(request()->post('food_party_id'));
            if (request()->food_count > $foodParty->quantity) {
                $quantity = (int)$foodParty->quantity;
                return [
                    'message' => "Bad Request: There are only $quantity of this food available in Food Party"
                ];
            }
            $cart = $cart = Cart::query()->create([
                'user_id' => Auth::user()->id,
                'restaurant_id' => $foodParty->food->restaurant->id,
            ]);
            $cart->foods()->attach($foodParty->food_id, [
                'food_count' => request()->food_count,
                'in_party' => 1,
                'discount_percent' => $foodParty->discount,
                'price' => $foodParty->food->price
            ]);
        }
        if (request()->has('food_id')) {
            $cart = $cart = Cart::query()->create([
                'user_id' => Auth::user()->id,
                'restaurant_id' => Food::query()->find(request()->food_id)->restaurant->id,
            ]);
            $food = Food::query()->find(request()->food_id);
            $cart->foods()->attach($food->id, [
                'food_count' => request()->food_count,
                'discount_percent' => $food->discount,
                'price' => $food->price
            ]);
        }
        $cart->update([
            'hashed_id' => strtolower(\Str::random(40))
        ]);
        return [
            'cart' => $cart,
            'data' => [
                'message' => 'Cart Created successfully',
                'cart_id' => $cart->id
            ]
        ];


    }
}



