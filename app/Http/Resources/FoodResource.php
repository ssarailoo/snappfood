<?php

namespace App\Http\Resources;

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
            'materials' => $this->materials,
            'image' => $this->image,
            'off' => [
                'label' => $this->discount."%",
                'factor' => $this->price*(100-$this->discount)/100
            ],
            ];


    }
}
