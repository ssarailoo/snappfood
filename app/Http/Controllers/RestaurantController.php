<?php

namespace App\Http\Controllers;

use App\Http\Requests\Restauarant\StoreRestaurantRequest;
use App\Http\Requests\Restauarant\UpdateRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize('viewAny', Restaurant::class);
        } catch (AuthorizationException $e) {

         return['customMessage'=>'You already have a restaurant'
             ];  // Your custom message

        }
        return view('restaurant.index', [
            'restaurants' => Restaurant::withTrashed()->get()
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
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        return view('restaurant.edit', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $restaurant->update($request->validated());
        return redirect()->route('dashboard')->with('success', 'Your Restaurant Updated Successfully');
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

//    public function restore($id)
//    {
//        $restaurant = Restaurant::withTrashed()->where('id', $id)->first();
//        $this->authorize('restore', $restaurant);
//        $restaurant->restore();
//        return redirect()->route('restaurants.index');
//
//    }
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
//    public function forceDelete($id)
//    {
//        $restaurant = Restaurant::withTrashed()->where('id', $id)->first();
//        $this->authorize('force-delete', $restaurant);
//        $restaurant->forceDelete();
//        return redirect()->route('restaurants.index');
//
//
//    }
}
