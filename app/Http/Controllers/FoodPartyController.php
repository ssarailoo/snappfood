<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodParty\StoreFoodPartyRequest;
use App\Http\Requests\FoodParty\UpdateFoodPartyRequest;
use App\Models\Food;
use App\Models\FoodParty;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class FoodPartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodPartyRequest $request, Restaurant $restaurant, Food $food)
    {
        $this->authorize('update', [$food, $restaurant]);
        FoodParty::query()->create($request->validated());
        return redirect()->route('my-restaurant.foods.index', [$restaurant, $food])->
        with('success',
            " {$request->post('quantity')} numbers of  $food->name added to Food Party with {$request->post('discount')} % discount! ");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodPartyRequest $request, Restaurant $restaurant, Food $food, FoodParty $foodParty)
    {
        $this->authorize('update', [$food, $restaurant]);
        $foodParty->update($request->validated());
        return redirect()->route('my-restaurant.foods.index', [$restaurant, $food])->
        with('success',
            "  $food->name updated in Food Party with {$request->post('discount')} % discount and numbers of {$request->post('quantity')}  ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Food $food, FoodParty $foodParty)
    {
        $this->authorize('delete', [$food, $restaurant]);
        $foodParty->delete();
        return redirect()->route('my-restaurant.foods.index', [$restaurant, $food])->
        with('success',
            "  $food->name deleted from Food Party ");

    }
}
