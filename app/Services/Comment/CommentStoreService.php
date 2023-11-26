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
        if ($cart->comments()->withTrashed()->first() == !null) {
            return ['msg' => 'Bad Request:You already have registered your opinion'];
        } elseif (!$cart->is_paid) {
            return ['msg' => 'Bad Request: Your cart has not been paid yet'];
        } elseif ($cart->status !== CartStatus::DELIVERED->value) {
            return ['msg' => 'Bad Request: Your order has not been delivered yet'];
        }
        Comment::query()->create($request->validated());
        return ['success' => true, 'msg' => "comment created successfully."];
    }

}
