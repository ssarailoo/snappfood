<?php

namespace App\Services\Comment;

use App\Enums\CartStatus;
use App\Enums\OrderStauts;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Cart\Cart;
use App\Models\Comment;
use App\Models\Order;

class CommentStoreService
{
    public function storeComment(StoreCommentRequest $request, int $orderId)
    {

        $order = Order::query()->find($orderId);
        if ($order->comments()->withTrashed()->first() !== null) {
            return ['msg' => 'Bad Request:You already have registered your opinion'];
        }  elseif ($order->status !== OrderStauts::DELIVERED->value) {
            return ['msg' => 'Bad Request: Your order has not been delivered yet'];
        }
        Comment::query()->create($request->validated());
        return ['success' => true, 'msg' => "comment created successfully."];
    }

}
