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
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('/images');
            $data = $request->validated();
            $data['image'] = $path;
        }


        $this->authorize('create', [Food::class, $restaurant]);
        Food::query()->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food, Restaurant $restaurant)
    {
        $this->authorize('view', [Food::class, $restaurant]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food, Restaurant $restaurant)
    {
        $this->authorize('update', [Food::class, $restaurant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Food $food, Restaurant $restaurant)
    {
        $this->authorize('update', [Food::class, $restaurant]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food, Restaurant $restaurant)
    {
        $this->authorize('delete', [Food::class, $restaurant]);
    }
}
