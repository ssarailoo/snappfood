<?php

namespace App\Http\Resources\Food;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $foods=$this->foods;
        if ($request->has('sort_by')) {
            $sortMethod = $request->get('sort_by');
            switch ($sortMethod) {
                case 'name_asc':
                    $foods = $foods->sortBy('name');
                    break;
                case 'name_desc':
                    $foods = $foods->sortByDesc('name');
                    break;
                case 'price_asc':
                    $foods = $foods->sortBy('price');
                    break;
                case 'price_desc':
                    $foods = $foods->sortByDesc('price');
                    break;
            }
        }
        return
            [
                'id' => $this->id,
                'title' => $this->name,
                'foods' => FoodResource::collection($foods),
            ];
    }
}
