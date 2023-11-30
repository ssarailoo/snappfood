<?php

namespace App\Services\Comment;

use App\Models\Food\Food;

class CommentFilterService
{
    public function filter($comments)
    {
        $statusFilter = request()->get('status');
        $foodFilter = request()->get('food');
        return $comments->when(!empty($statusFilter), function ($query) use ($statusFilter) {
            return $query->filter(fn($comment) => $comment->status === $statusFilter);
        })->when(!empty($foodFilter), function ($query) use ($foodFilter) {
            $food = Food::query()->find($foodFilter);
            return $query->filter(function ($comment) use ($food) {
                return $comment->order->foods->contains($food);
            });
        });
}
}
