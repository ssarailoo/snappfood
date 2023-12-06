<?php

namespace App\Http\Controllers\Web\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restauarant\StoreRestaurantRequest;
use App\Http\Requests\Restauarant\UpdateRestaurantRequest;
use App\Http\Requests\Restaurant\RestaurantFilterRequest;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Restaurant::class, 'restaurant');
    }

    public function index(RestaurantFilterRequest $request)
    {

        $categoryFilter = $request->get('restaurant_category_id');
        return view('restaurant.index', [
            'restaurants' => Restaurant::withTrashed()->with(['image', 'restaurantCategory', 'user'])
                ->when($categoryFilter, function ($query) use ($categoryFilter) {
                    return $query->where('restaurant_category_id', $categoryFilter);
                })
                ->get(),
        ]);

    }


    public function show(Restaurant $restaurant, Request $request)
    {

        return view('restaurant.show', [
            'restaurant' => $restaurant
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        try {
            $restaurant = Restaurant::query()->create($request->validated());
            $restaurant->image()->create([
                'url' => 'images/default-restaurant.png',
            ]);
            //assign role of manager to the user
            Auth::user()->assignRole(Role::query()->find(2));
        } catch (QueryException $e) {
            Log::error('Error Creating Restaurant ' . $e->getMessage());
            return view('error.500', ['route' => route("dashboard")]);
        }
        return redirect()->route('dashboard')->with('success', 'Your Restaurant Created Successfully');

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        $latitude = $restaurant->latitude ?? 0; // Provide a default value if null
        $longitude = $restaurant->longitude ?? 0;
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
        try {
            $restaurant->update($request->validated());
            if ($request->hasFile('url'))
                $restaurant->image->update([
                    'url' => $request->file('url'),
                ]);
        } catch (QueryException $e) {
            Log::error('Error Updating Restaurant ' . $e->getMessage());
            return view('error.500', ['route' => route("restaurants.edit", $restaurant)]);
        }
        return redirect()->route('restaurants.edit', $restaurant)->with('success', "{$restaurant->name} has been Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(Restaurant $restaurant)
    {
        try {
            $restaurant->delete();
        } catch
        (QueryException $e) {
            Log::error('Error Deleting Restaurant ' . $e->getMessage());
            return view('error.500', ['route' => route("restaurants.edit", $restaurant)]);
        }
        return redirect()->route('dashboard')->with('success', 'Your Restaurant Deleted Successfully');
    }


    public
    function restore(Restaurant $restaurant)
    {
        try {
            $restaurant->restore();
        } catch
        (QueryException $e) {
            Log::error('Error Restoring Restaurant ' . $e->getMessage());
            return view('error.500', ['route' => route("restaurants.index")]);
        }
        return redirect()->route('restaurants.index');

    }

    public
    function forceDelete(Restaurant $restaurant)
    {
        try {
            $restaurant->forceDelete();
        } catch
        (QueryException $e) {
            Log::error('Error Force Deleting Restaurant ' . $e->getMessage());
            return view('error.500', ['route' => route("restaurants.index", $restaurant)]);
        }
        return redirect()->route('restaurants.index');

    }

    public
    function saveLocation(Request $request, Restaurant $restaurant)
    {
        $restaurant->update([
            'longitude' => $request->post('longitude'),
            'latitude' => $request->post('latitude')
        ]);

    }

}
