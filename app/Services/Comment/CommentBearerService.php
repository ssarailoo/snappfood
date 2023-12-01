<?php

namespace App\Services\Comment;

use App\Enums\CommentStatus;
use App\Http\Requests\Comment\GetCommentsRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Models\Food\Food;
use App\Models\Restaurant\Restaurant;

class CommentBearerService
{

    public function getComments(GetCommentsRequest $request)
    {

        $restaurantId = $request->get('restaurant_id');
        $foodId = $request->get('food_id');
        if ($restaurantId) {

          return  $response = new CommentCollection(Restaurant::query()->find($restaurantId)->comments->filter(function ($comment) {
                return   $comment->parent_id === null and $comment->status === CommentStatus::Accepted->value;
            }));
        }
            $orders = Food::query()->find($foodId)->orders->filter(fn($order) => $order->comments->first() == !null);

            $response = new CommentCollection($orders->map(fn($order) => $order->comments)->map(fn($comment) => $comment->first())
                ->filter(fn($comment) => $comment->status === CommentStatus::Accepted->value));

            return $response;

    }
}
