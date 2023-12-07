<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'restaurant' => [
                'title' => $this->restaurant->name,
                'image'=>asset('storage/'.$this->restaurant->image->url)
            ],
            'foods' => CartFoodResource::collection($this->cartFoods),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'total'=>$this->total." $"
        ];
    }
}
