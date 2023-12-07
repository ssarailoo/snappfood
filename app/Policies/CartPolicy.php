<?php

namespace App\Policies;


use App\Models\Cart\Cart;
use App\Models\Discount;
use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartPolicy
{

    public function view(User $user, Cart $cart): Response
    {
        return $user->carts->contains($cart) ? Response::allow() : Response::deny('this cart does not belongs to you')->withStatus(403);
    }

    public function create(): Response
    {
        $food = request()->has('food_id') ? Food::query()->find(request()->food_id) : FoodParty::query()->find(\request()->food_party_id)->food;
        $currentDay = Carbon::now()->format('l');
        $currentSchedules = $food->restaurant->schedules->where('day.name', $currentDay);
        if ($currentSchedules === null)
            return Response::deny('Today Restaurant is closed')->withStatus(400);
        $currentTime = Carbon::now();
        $isClose = $currentSchedules->filter(function ($currentSchedule) use ($currentTime) {
            $startTime = Carbon::parse($currentSchedule->start_time);
            $endTime = Carbon::parse($currentSchedule->end_time);
            return $currentTime->between($startTime, $endTime);
        })->isEmpty();
        if ($isClose)
            return Response::deny('Restaurant is closed')->withStatus(400);
        if ($food->restaurant->status === 0)
            return Response::deny('Restaurant is not available')->withStatus(400);
        if (Auth::user()->currentAddress === null)
            return Response::deny('First add your current Address')->withStatus(400);
        return Response::allow();
    }

    public function update(User $user, Cart $cart): Response
    {
        if (!$user->carts->contains($cart)) {
            return Response::deny('this cart does not belongs to you')->withStatus(403);
        }
        $newFood = Food::query()->find(request()->post('food_id'));
        $newFoodParty = FoodParty::query()->find(request()->post('food_party_id'));
        if ($newFood and $cart->restaurant->isNot($newFood->restaurant)) {
            return Response::deny(' you cant order food from 2 different restaurants')->withStatus(400);
        }
        if ($newFoodParty and $cart->restaurant->isNot($newFoodParty->food->restaurant)) {
            return Response::deny(' you cant order food from 2 different restaurants')->withStatus(400);
        }

        return Response::allow();
    }

    public function delete(User $user, Cart $cart): Response
    {
        return $user->carts->contains($cart) ? Response::allow() : Response::deny('this cart does not belongs to you')->withStatus(403);

    }

    public function pay(User $user, Cart $cart)
    {
        if (!$user->carts->contains($cart)) {
            return Response::deny('this cart does not belongs to you')->withStatus(400);
        }
        $discount = Discount::query()->where('code', request()->input('code'))->first();
        if ($discount and $user->orders->contains(Order::query()->where('discount_id', $discount->id)->first())) {
            return Response::deny('you can use this code only once')->withStatus(400);
        }
        return Response::allow();

    }
}
