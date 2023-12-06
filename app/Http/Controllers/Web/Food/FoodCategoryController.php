<?php

namespace App\Http\Controllers\Web\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreFoodCategoryRequest;
use App\Http\Requests\Category\UpdateFoodCategoryRequest;
use App\Models\Food\FoodCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class FoodCategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FoodCategory::class, 'foodCategory');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('category.food.index', [
            'categories' => FoodCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('category.food.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodCategoryRequest $request)
    {
        try {
            FoodCategory::query()->create($request->validated());
        } catch (QueryException $e) {
            Log::error('Error creating FoodCategory: ' . $e->getMessage());
        }
        return redirect()->route('food-categories.index');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodCategoryRequest $request, FoodCategory $foodCategory)
    {
        try {
            $foodCategory->update($request->validated());
        } catch (QueryException $e) {
            Log::error('Error Updating FoodCategory: ' . $e->getMessage());
        }

        return redirect()->route('food-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodCategory $foodCategory)
    {
        try {
            $foodCategory->delete();
        } catch (QueryException $e) {
            Log::error('Error Destroying FoodCategory: ' . $e->getMessage());
        }
        return redirect()->route('food-categories.index');
    }
}
