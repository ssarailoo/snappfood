<?php

namespace App\Http\Controllers;

use App\Http\Requests\Food\StoreFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Models\Food;
use App\Models\Restaurant;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('viewAny', [Food::class, $restaurant]);

        return view('food.index', [
            'restaurant' => $restaurant,
            'foods' => Food::query()->where('restaurant_id', $restaurant->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Restaurant $restaurant)
    {
        $this->authorize('create', [Food::class, $restaurant]);

        return view('food.create', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodRequest $request, Restaurant $restaurant)
    {


        $this->authorize('create', [Food::class, $restaurant]);
        Food::query()->create($request->validated());

        return redirect()->route('my-restaurant.foods.index', $restaurant)->with('success', 'New Food added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant, Food $food)
    {
        $this->authorize('view', [$food, $restaurant]);
        return view('food.show', [
            'food' => $food
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant, Food $food)
    {

        $this->authorize('update', [$food, $restaurant]);
        return view('food.edit', [
            'restaurant' => $restaurant,
            'food' => $food
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Restaurant $restaurant, Food $food)
    {
        $this->authorize('update', [$food, $restaurant]);
        $food->update($request->validated());
        return redirect()->route('my-restaurant.foods.index', $restaurant)->with('success', "$food->name updated successfully ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Food $food,)
    {
        $this->authorize('delete', [$food, $restaurant]);
        $food->delete();
        return redirect()->route('my-restaurant.foods.index', $restaurant)->with('success', "$food->name deleted successfully ");
    }
}
