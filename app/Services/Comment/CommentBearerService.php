<?php

namespace App\Services\Comment;

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

            $response = new CommentCollection(Restaurant::query()->find($restaurantId)->comments->filter(function ($comment) {
                return $comment->parent_id === null;
            }));
        } elseif ($foodId) {
            $carts = Food::query()->find($foodId)->carts->filter(fn($cart) => $cart->is_paid === 1 && $cart->comments->first() == !null);

            $response = new CommentCollection($carts->map(fn($cart)=>$cart->comments)->map(fn($comment)=>$comment->first()));
        } else
            $response = [
                'msg' => 'Bad Request=> you must enter food id or restaurant id in query param'
            ];
        return $response;
    }
}
