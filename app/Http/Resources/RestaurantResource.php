<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'title' => $this->name,
            'type' => $this->restaurantCategory->name,
            'address' => [
                'address' => $this->address,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
            ],
            'is_open' => $this->status === 1,
            'image'=> asset('storage/'. $this->image->url),
            'score' => $this->score ?? 'no score registered yet.',
            'comments_count' => $this->when($request->route()->hasParameter('restaurant'), count($this->comments)),
            'schedules' => $this->when($request->route()->hasParameter('restaurant'), ScheduleResourece::collection($this->schedules))


        ];
    }
}

