<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use App\Http\Requests\StoreFoodCategoryRequest;
use App\Http\Requests\UpdateFoodCategoryRequest;
use App\Models\RestaurantCategory;

class FoodCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', FoodCategory::class);
        return view('category.food.index', [
            'categories' => FoodCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', FoodCategory::class);
        return view('category.food.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodCategoryRequest $request)
    {
        $this->authorize('create', FoodCategory::class);
        FoodCategory::query()->create($request->validated());
        return redirect()->route('food-categories.index');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodCategoryRequest $request, FoodCategory $foodCategory)
    {
        $this->authorize('create', $foodCategory);
        $foodCategory->update($request->validated());
        return redirect()->route('food-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodCategory $foodCategory)
    {
        $this->authorize('create', $foodCategory);
        $foodCategory->delete();
        return redirect()->route('food-categories.index');
    }
}
