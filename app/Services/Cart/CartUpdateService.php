<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use Illuminate\Support\Facades\DB;

class CartUpdateService
{
    public function updateService(Cart $cart)
    {

        $count = request()->post('food_count');
        $newFood = Food::query()->find(request()->post('food_id'));
        $newFoodParty = FoodParty::query()->find(request()->post('food_party_id'));
        if (request()->has('food_id')) {
            $foodParty = FoodParty::query()->where('food_id', $newFood->id)->first();
            $cart->foods()->syncWithoutDetaching([
                $newFood->id => [
                    'food_count' => DB::raw('food_count + ' . $count),
                    'discount_percent' => $foodParty === null ? $newFood->discount : $foodParty->discount,
                    'price' => $newFood->price,
                    'in_party' => $foodParty === null ? 0 : 1
                ],
            ]);
            if ($foodParty !== null)
                $foodParty->decrement('quantity', $count);

        } elseif (request()->has('food_party_id')) {
            $cart->foods()->syncWithoutDetaching([$newFoodParty->food_id => [
                'food_count' => DB::raw('food_count + ' . $count),
                'in_party' => 1,
                'discount_percent' => $newFoodParty->discount,
                'price' => $newFoodParty->food->price
            ]]);
            $newFoodParty->decrement('quantity', request()->food_count);
        }
        $cart->cartFoods->map(function ($cartFood) {
            if ($cartFood->food_count <= 0)
                $cartFood->update([
                    'food_count' => 0
                ]);

        });

        return [
            'success' => true,
            'message' => 'your cart updated successfully',
        ];

    }

}
