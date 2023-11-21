<?php

namespace App\Http\Resources\Food;

use App\Models\Food\Food;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodPartyResource extends JsonResource
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
            'food' => Food::query()->find($this->food_id)->name,
            'materials' => Food::query()->find($this->food_id)->materials->map(fn($material)=>$material->name),
            'restaurant' => Food::query()->find($this->food_id)->restaurant->name,
            'quantity' => (int)$this->quantity,
            'discount' => $this->discount ." %",
            'final_price' => Food::query()->find($this->food_id)->price * (100 - $this->discount) / 100
        ];
    }
}
