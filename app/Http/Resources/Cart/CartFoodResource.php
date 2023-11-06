<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartFoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->food->id,
            'title' => $this->food->name,
            'count' => $this->food_count,
            'price' => $this->food->price,
            'discount' => $this->discount ?? 0 . "%"
        ];
    }
}
