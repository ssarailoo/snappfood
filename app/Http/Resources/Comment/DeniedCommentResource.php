<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeniedCommentResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'restaurant' => $this->cart->restaurant->name,
            'foods' => [
                $this->cart->foods->map(fn($food) => $food->name)
            ],
            'score' => $this->score,
            'content' => $this->content,
            'description' => $this->description
        ];
    }
}
