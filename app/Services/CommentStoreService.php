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
        if ($cart->comments->first()==! null) {
            return ['msg' => 'Bad Request:You already have registered your opinion'];
        } elseif (!$cart->is_paid) {
            return ['msg' => 'Bad Request: Your cart has not been paid yet'];
        }
        Comment::query()->create($request->validated());
        return ['success' => true, 'msg' => "comment created successfully."];
    }

}
