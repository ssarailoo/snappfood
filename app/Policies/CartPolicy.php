<?php

namespace App\Policies;


use App\Models\Cart\Cart;
use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class CartPolicy
{

    public function isCartBelongingToUser(User $user, Cart $cart): bool
    {
        return $user->carts->contains($cart);
    }

    public function create(): Response
    {

        if (request()->has('food_id')) {
            return Food::query()->find(request()->food_id)->restaurant->status === 0 ? Response::deny('Restaurant is closed')->withStatus(400) : Response::allow();
        }
        return FoodParty::query()->find(\request()->food_party_id)->food->restaurant->status === 0 ? Response::deny('Restaurant is closed')->withStatus(400) : Response::allow();
    }


}
