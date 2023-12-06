<?php

namespace App\Http\Controllers\Web\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodParty\SetFoodPartyTimesRequest;
use App\Http\Requests\FoodParty\StoreFoodPartyRequest;
use App\Http\Requests\FoodParty\UpdateFoodPartyRequest;
use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class FoodPartyController extends Controller
{



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodPartyRequest $request, Restaurant $restaurant, Food $food)
    {
        $this->authorize('create',[Food::class, $restaurant]);
        try {
            FoodParty::query()->create($request->validated());
        }catch (QueryException $e){
            Log::error('Error Creating new Food Party '.$e->getMessage());
            return view('error.500', ['route' => route("my-restaurant.foods.index",$restaurant)]);
        }
        return redirect()->route('my-restaurant.foods.index', $restaurant)->
        with('success',
            " {$request->post('quantity')} numbers of  $food->name added to Food Party with {$request->post('discount')} % discount! ");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodPartyRequest $request, Restaurant $restaurant, Food $food, FoodParty $foodParty)
    {
        $this->authorize('update', [Food::class, $restaurant]);
        try {
            $foodParty->update($request->validated());
        }catch (QueryException $e){
            Log::error('Error Updating Food Party '.$e->getMessage());
            return view('error.500', ['route' => route("my-restaurant.foods.index",$restaurant)]);
        }
        return redirect()->route('my-restaurant.foods.index', [$restaurant, $food])->
        with('success',
            "  $food->name updated in Food Party with {$request->post('discount')} % discount and numbers of {$request->post('quantity')}  ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Food $food, FoodParty $foodParty)
    {
        $this->authorize('delete', [Food::class, $restaurant]);
        try {
            $foodParty->delete();
        }catch (QueryException $e){
            Log::error('Error Deleting Food Party '.$e->getMessage());
            return view('error.500', ['route' => route("my-restaurant.foods.index",$restaurant)]);
        }
        return redirect()->route('my-restaurant.foods.index', [$restaurant, $food])->
        with('success',
            "  $food->name deleted from Food Party ");

    }

    public function showSetting()
    {
        $this->authorize('foodParty',Food::class);
        return view('party.showSetting');
    }

    public function setting(SetFoodPartyTimesRequest $request)
    {
        $this->authorize('foodParty',Food::class);

        FoodParty::setTimes($request);

        return redirect()->route('dashboard')->with('success', 'Times of food party has been updated');
    }
}
