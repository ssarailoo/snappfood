<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Models\Food\Food;
use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant, Request $request)
    {
        $this->authorize('viewAny', [Food::class, $restaurant]);
        $foodsOfRestaurant = Food::query()->foodsOf($restaurant->id);
        $sortMethod = $request->input('sort_by', 'default_sort');
        $foods = Food::getSortedFoods($request, $foodsOfRestaurant);
        return view('food.index', [
            'restaurant' => $restaurant,
            'foods' => $foods->paginate(3),
            'sortMethod' => $sortMethod
        ]);

    }

    public function filter(Request $request)
    {
        $foodCategoryId = $request->get('food_category_id');
        $id = $request->get('restaurant_id');
        $restaurant = Restaurant::query()->find($id);
        $filteredFoods = Food::query()->foodsOf($id)->filterBy('food_category_id', $foodCategoryId);
        return view('food.filtered', [
            'restaurant' => $restaurant,
            'foods' => $filteredFoods->get(),
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

        $this->authorize('update', [Food::class, $restaurant]);
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
        $this->authorize('update', [Food::class, $restaurant]);
        $food->update($request->validated());
        return redirect()->route('my-restaurant.foods.index', $restaurant)->with('success', "$food->name updated successfully ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Food $food,)
    {
        $this->authorize('delete', [Food::class, $restaurant]);
        $food->delete();
        return redirect()->route('my-restaurant.foods.index', $restaurant)->with('success', "$food->name deleted successfully ");
    }
}
