<?php

namespace App\Services;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Cart\Cart;
use App\Models\Comment;

class CommentStoreService
{
    public function storeComment(StoreCommentRequest $request, int $cartId)
    {

        $cart = Cart::query()->find($cartId);
        if ($cart->comments->first() == !null) {
            return ['msg' => 'Bad Request:You already have registered your opinion'];
        } elseif (!$cart->is_paid) {
            return ['msg' => 'Bad Request: Your cart has not been paid yet'];
        }
        Comment::query()->create($request->validated());
        $restaurant = Cart::query()->find(1)->restaurant;
        $count = count($restaurant->carts);
        $scores = $restaurant->carts->map(fn($cart) => $cart->comments->first()->score)->sum();
        $restaurant->update([
            'score' => $scores / $count
        ]);
        return ['success' => true, 'msg' => "comment created successfully."];
    }

}
