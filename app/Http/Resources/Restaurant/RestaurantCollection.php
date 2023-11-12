<?php

namespace App\Http\Resources\Restaurant;

use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RestaurantCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

             return [
                 Restaurant::all()->map(function ($restaurant){
                     return [
                         'id' => $restaurant->id,
                         'title' => $restaurant->name,
                         'type' => $restaurant->restaurantCategory->name,
                         'address' => [
                             'address' => $restaurant->address,
                             'longitude' => $restaurant->longitude,
                             'latitude' => $restaurant->latitude,
                         ],
                         'is_open' => $restaurant->status === 1,
                         'image' => asset('storage/' . $restaurant->image->url),
                         'score'=>$restaurant->score?? 'no score registered yet.',
                     ];

                 }),
        ];
    }
}
