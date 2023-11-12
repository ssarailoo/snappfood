<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\FilterFoodRequest;
use App\Http\Resources\Food\FoodCategoryCollection;
use App\Models\Food\FoodCategory;
use App\Models\Restaurant\Restaurant;

class FoodController extends Controller
{
    /**
     *  Display a listing of the resource.
     * @group Food
     * @apiResourceCollection App\Http\Resources\Food\FoodCategoryCollection
     * @apiResourceModel App\Models\Food\FoodCategory
     */


    public function index(Restaurant $restaurant, FilterFoodRequest $request)
    {

            $foods = $restaurant->foods;
            $categoryIds = $foods->map(fn($food) => $food->food_category_id)->unique();
            return response()->json(new FoodCategoryCollection(FoodCategory::query()->whereIn('id', $categoryIds)->get()), 200);

    }
}
