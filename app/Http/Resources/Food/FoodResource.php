<?php

namespace App\Http\Resources\Food;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
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
            'price' => $this->price,
            'materials' => $this->materials->map(fn($material)=>$material->name),
            'image' =>asset('storage/'. $this->image->url),
            'off' => [
                'label' => $this->discount . "%",
                'factor' => $this->price * (100 - $this->discount) / 100
            ],
        ];


    }
}
