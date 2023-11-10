<?php

namespace App\Http\Controllers\Web\Restaurant;

use App\Http\Controllers\Web\Controller;
use App\Http\Requests\Category\StoreRestaurantCategoryRequest;
use App\Http\Requests\Category\UpdateRestaurantCategoryRequest;
use App\Models\Restaurant\RestaurantCategory;

class RestaurantCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',RestaurantCategory::class);
        return view('category.restaurant.index', [
            'categories' => RestaurantCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',RestaurantCategory::class);
        return view('category.restaurant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantCategoryRequest $request)
    {
        $this->authorize('create',RestaurantCategory::class);
        RestaurantCategory::query()->create($request->validated());
        return redirect()->route('rest-categories.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantCategoryRequest $request, RestaurantCategory $restaurantCategory)
    {
        $this->authorize('update',$restaurantCategory);
        $restaurantCategory->update($request->validated());
        return redirect()->route('rest-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestaurantCategory $restaurantCategory)
    {
        $this->authorize('delete',$restaurantCategory);
        $restaurantCategory->delete();
        return redirect()->route('rest-categories.index');
    }
}
