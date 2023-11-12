<?php

namespace App\Http\Controllers\Web\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRestaurantCategoryRequest;
use App\Http\Requests\Category\UpdateRestaurantCategoryRequest;
use App\Models\Restaurant\RestaurantCategory;

class RestaurantCategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(RestaurantCategory::class,'restaurantCategory');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('category.restaurant.index', [
            'categories' => RestaurantCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('category.restaurant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantCategoryRequest $request)
    {

        RestaurantCategory::query()->create($request->validated());
        return redirect()->route('rest-categories.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantCategoryRequest $request, RestaurantCategory $restaurantCategory)
    {

        $restaurantCategory->update($request->validated());
        return redirect()->route('rest-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestaurantCategory $restaurantCategory)
    {

        $restaurantCategory->delete();
        return redirect()->route('rest-categories.index');
    }
}
