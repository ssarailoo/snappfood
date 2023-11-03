<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restauarant\StoreRestaurantRequest;
use App\Http\Requests\Restauarant\UpdateRestaurantRequest;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Restaurant::class);
        $categoryFilter = $request->get('restaurant_category_id');
        return view('restaurant.index', [
            'restaurants' => Restaurant::withTrashed()
                ->when($categoryFilter, function ($query) use ($categoryFilter) {
                    return $query->where('restaurant_category_id', $categoryFilter);
                })
                ->get(),
        ]);
    }

    public function show(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        return view('restaurant.show', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Restaurant::class);
        return view('restaurant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        $this->authorize('create', Restaurant::class);
        Restaurant::query()->create($request->validated());
        //assign role of manager to the user
        Auth::user()->assignRole(Role::query()->find(2));
        return redirect()->route('dashboard')->with('success', 'Your Restaurant Created Successfully');

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        $latitude = $restaurant->latitude ?? 0; // Provide a default value if null
        $longitude = $restaurant->longitude ?? 0;
        $this->authorize('update', $restaurant);
        return view('restaurant.edit', [
            'restaurant' => $restaurant,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $restaurant->update($request->validated());
        return redirect()->route('restaurants.edit',$restaurant)->with('success', "{$restaurant->name} has been Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);
        $restaurant->delete();
        return redirect()->route('dashboard')->with('success', 'Your Restaurant Deleted Successfully');
    }


    public function restore(Restaurant $restaurant)
    {
        $this->authorize('restore', $restaurant);
        $restaurant->restore();
        return redirect()->route('restaurants.index');

    }

    public function forceDelete(Restaurant $restaurant)
    {
        $this->authorize('force-delete', $restaurant);
        $restaurant->forceDelete();
        return redirect()->route('restaurants.index');

    }

    public function saveLocation(Request $request, Restaurant $restaurant)
    {
        $restaurant->update([
            'longitude' => $request->post('longitude'),
            'latitude' => $request->post('latitude')
        ]);

    }

}
