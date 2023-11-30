<?php

namespace App\Services\Restaurant;

use App\Enums\CommentStatus;

class RestaurantUpdateScoreService
{
    public function updateRestaurantScore($restaurant,$newStatus)
    {
        if ($newStatus ===CommentStatus::Accepted->value){
          $orders=  $restaurant->orders->filter(fn($order)=>$order->comments->first()!==null);
            $count = count($orders);
            $scores = $orders->map(fn($order) => $order->comments->first()->score )->sum();
            $restaurant->update([
                'score' => $scores / $count
            ]);
        }

    }

}
