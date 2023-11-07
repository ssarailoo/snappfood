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

        $array = [
                'author' => [
                    'name' => $this->cart->user->name,
                ],
                'foods' => [
                    $this->cart->foods->map(fn($food) => $food->name)
                ],
                'created_at' => $this->created_at,
                'score' => $this->score,
                'content' => $this->content,
                'answer' => $answer->content ?? null

            ];
     if (is_null($array['answer'])){
         unset($array['answer']);
     }


    return $array;









    }
}
