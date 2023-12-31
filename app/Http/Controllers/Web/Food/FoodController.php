<?php

namespace App\Http\Controllers\Web\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\FilterFoodRequest;
use App\Http\Requests\Food\StoreFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Models\Food\Food;
use App\Models\Restaurant\Restaurant;
use App\Services\Material\MaterialCreateOrRetrieveService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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

        $this->authorize('viewAny', [Food::class, $restaurant]);
        $foodsOfRestaurant = Food::query()->with(['image', 'materials', 'foodParties'])->foodsOf($restaurant->id);
        $foods = Food::getSortedFoods($request, $foodsOfRestaurant);
        return view('food.index', [
            'restaurant' => $restaurant,
            'foods' => $foods->paginate(10),
        ]);


    }

    public function filter(Request $request)
    {
        $foodCategoryId = $request->get('food_category_id');
        $id = $request->get('restaurant_id');
        $restaurant = Restaurant::query()->find($id);
        $filteredFoods = Food::query()->foodsOf($id)->when($foodCategoryId, fn($query) => $query->filterBy('food_category_id', $foodCategoryId));
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
    public function store(StoreFoodRequest $request, Restaurant $restaurant, MaterialCreateOrRetrieveService $service)
    {

        $this->authorize('create', [Food::class, $restaurant]);
        try {
            $food = Food::query()->create($request->except('materials'));
            $materials = $service->createOrRetrieveMaterials(array_values($request->input('materials')));
            $food->materials()->sync($materials);
            $food->image()->create([
                'url' => $request->file('image') ?? 'images/default-food.jpeg',
            ]);
        } catch (QueryException $e) {
            Log::error('Error creating new food: ' . $e->getMessage());
            return view('error.500', ['route' => route("my-restaurant.foods.index", $restaurant)]);
        }
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
    public function update(UpdateFoodRequest $request, Restaurant $restaurant, Food $food, MaterialCreateOrRetrieveService $service)
    {
        $this->authorize('update', [Food::class, $restaurant]);
        try {
            $food->update($request->except('materials'));
            $materials = $service->createOrRetrieveMaterials(array_values($request->input('materials')));
            $food->materials()->sync($materials);
            if ($request->hasFile('url'))
                $food->image->update([
                    'url' => $request->file('url'),
                ]);
        } catch (QueryException $e) {
            Log::error('Error Updating  food: ' . $e->getMessage());
            return view('error.500', ['route' => route("my-restaurant.foods.index", $restaurant)]);
        }

        return redirect()->route('my-restaurant.foods.index', $restaurant)->with('success', "$food->name updated successfully ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Food $food,)
    {
        try {
            $this->authorize('delete', [Food::class, $restaurant]);
            $food->delete();
        } catch (QueryException $e) {
            Log::error('Error Deleting  food: ' . $e->getMessage());
            return view('error.500', ['route' => route("my-restaurant.foods.index", $restaurant)]);
        }
        return redirect()->route('my-restaurant.foods.index', $restaurant)->with('success', "$food->name deleted successfully ");
    }
}
