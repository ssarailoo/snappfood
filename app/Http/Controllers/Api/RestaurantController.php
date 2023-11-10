<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Web\Controller;
use App\Http\Requests\Restaurant\RestaurantFilterRequest;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant\Restaurant;


class RestaurantController extends Controller
{




    /** @group Restaurant
     * Display a listing of the Restaurant resource.
     * @apiResourceCollection App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant\Restaurant
     *
     */
    public function index(RestaurantFilterRequest $request)
    {
        $query = Restaurant::filterApi($request);

        return response(RestaurantResource::collection($query->get()), 200);

    }

    /**
     * Display a specific Restaurant
     * @group Restaurant
     * @apiResource App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant\Restaurant
     * @urlParam name required The name of the restaurant Example:neshat
     *
     */

    public function show(Restaurant $restaurant)
    {

        return response(new RestaurantResource($restaurant), 200);

    }


}
