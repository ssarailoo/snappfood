<?php

namespace App\Http\Resources\Comment;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function PHPUnit\Framework\isNull;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $answer = Comment::query()->where('parent_id', $this->id)->first();

        return [
            'author' => [
                'name' => $this->cart->user->name,
            ],

            'foods' => $this->when($request->has('restaurant_id'), [
                $this->cart->foods->map(fn($food) => $food->name)
            ]),
            'restaurant' => $this->when($request->has('food_id'), $this->cart->restaurant->name),
            'created_at' => $this->created_at,
            'score' => $this->score,
            'content' => $this->content,
            'answer' =>$this->whennotNull( $answer->content ??null)

        ];


    }
}
