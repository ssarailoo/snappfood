<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Models\Food\Food;
use App\Models\Food\FoodParty;

class CartUpdateService
{
    public function updateService(Cart $cart)
    {
        $newFoodId = request()->post('food_id');
        $newFood=Food::query()->find($newFoodId);
        $newFoodParty = FoodParty::query()->find(request()->post('food_party_id'));
        if (request()->has('food_id')) {
            if ($cart->restaurant->isNot(Food::query()->find($newFoodId)->restaurant)) {
                return [
                    'message' => 'Bad Request: you cant order food from 2 different restaurants'
                ];
            }
        } elseif (request()->has('food_party_id')) {
            if ($cart->restaurant->isNot($newFoodParty->food->restaurant)) {
                return [
                    'message' => 'Bad Request: you cant order food from 2 different restaurants'
                ];
            } elseif (request()->post('food_count') > $newFoodParty->quantity) {
                return [
                    'message' => "Bad Request: There are only $newFoodParty->quantity of this food available in Food Party"
                ];
            }
        }
        if (request()->has('food_id'))
            $cart->foods()->attach($newFoodId, [
                'food_count' => request()->post('food_count'),
                'discount_percent' => $newFood->discount,
                'price' => $newFood->price
            ]);
        else
            $cart->foods()->attach($newFoodParty->food->id, [
                'food_count' => request()->post('food_count'),
                    'in_party'=>1,
                    'discount_percent' => $newFoodParty->discount,
                    'price' => $newFoodParty->food->price
                ]
            );
            return [
                'success' => true,
                'message' => 'your cart updated successfully',
            ];

    }

}
