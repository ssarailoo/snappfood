<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\RestaurantFilterRequest;
use App\Http\Resources\Restaurant\RestaurantCollection;
use App\Http\Resources\Restaurant\RestaurantResource;
use App\Models\Restaurant\Restaurant;
use Illuminate\Support\Facades\Auth;


class RestaurantController extends Controller
{




    /** @group Restaurant
     * Display a listing of the Restaurant resource.
     * @apiResourceCollection App\Http\Resources\Restaurant\RestaurantResource
     * @apiResourceModel App\Models\Restaurant\Restaurant
     *
     */
    public function index(RestaurantFilterRequest $request)
    {
        $currentAddress = Auth::user()->currentAddress;
        $lat = $currentAddress->latitude;
        $lon = $currentAddress->longitude;
        $restaurants = Restaurant::query()->nearBy($lat, $lon);
        $restaurants = Restaurant::filterApi($request,$restaurants)->get();



        return response()->json(new RestaurantCollection($restaurants), 200);
    }

    /**
     * Display a specific Restaurant
     * @group Restaurant
     * @apiResource App\Http\Resources\Restaurant\RestaurantResource
     * @apiResourceModel App\Models\Restaurant\Restaurant
     * @urlParam name required The name of the restaurant Example:neshat
     *
     */

    public function show(Restaurant $restaurant)
    {

        return response()->json(new RestaurantResource($restaurant), 200);

    }


}
