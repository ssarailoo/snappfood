<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartStoreService
{
    public function storeCart()
    {
        $count = request()->food_count;
        if (request()->has('food_party_id')) {
            $foodParty = FoodParty::query()->find(request()->post('food_party_id'));
            $cart =  Cart::query()->where('is_paid',0)->updateOrCreate([
                'user_id' => Auth::user()->id,
                'restaurant_id' => $foodParty->food->restaurant->id,
            ]);
            $cart->foods()->syncWithoutDetaching([$foodParty->food_id=> [
                'food_count' => DB::raw('food_count + ' . $count),
                'in_party' => 1,
                'discount_percent' => $foodParty->discount,
                'price' => $foodParty->food->price
            ]]);
            $foodParty->decrement('quantity', request()->food_count);
        }
        if (request()->has('food_id')) {
            $food = Food::query()->find(request()->food_id);
            $foodParty = FoodParty::query()->where('food_id', $food->id)->first();
            $cart = $cart = Cart::query()->updateOrCreate([
                'user_id' => Auth::user()->id,
                'restaurant_id' => Food::query()->find(request()->food_id)->restaurant->id,
                'is_paid' => 0
            ]);
            $cart->foods()->syncWithoutDetaching([
                $food->id => [
                    'food_count' => DB::raw('food_count + ' . $count),
                    'discount_percent' => $foodParty === null ? $food->discount : $foodParty->discount,
                    'price' => $food->price,
                    'in_party' => $foodParty === null ? 0 : 1
                ],
            ]);
            if ($foodParty !== null)
                $foodParty->decrement('quantity', $count);
        }
        $cart->update([
            'hashed_id' => strtolower(\Str::random(40))
        ]);

        return [
            'cart' => $cart,
            'data' => [
                'message' => $cart->wasRecentlyCreated ? 'Cart Created successfully' : "You have an unpaid  cart from this restaurant, the desired food has been added to it, you must use the update method",
                'cart_id' => $cart->id
            ]
        ];


    }
}



