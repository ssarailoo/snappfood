<?php

namespace App\Services\Comment;

use App\Enums\CartStatus;
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
        } elseif ($cart->status !== CartStatus::DELIVERED->value) {
            return ['msg' => 'Bad Request: Your order has not been delivered yet'];
        }
        Comment::query()->create($request->validated());
        $restaurant = Cart::query()->find($request->cart_id)->restaurant;
        $count = count($restaurant->carts);
        $scores = $restaurant->carts->map(fn($cart) => $cart->comments->first()->score ?? 0)->sum();
        $restaurant->update([
            'score' => $scores / $count
        ]);
        return ['success' => true, 'msg' => "comment created successfully."];
    }

}
