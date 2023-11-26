<?php

namespace App\Services\Restaurant;

use App\Enums\CommentStatus;

class RestaurantUpdateScoreService
{
    public function updateRestaurantScore($restaurant,$newStatus)
    {
        if ($newStatus ===CommentStatus::Accepted){
            $count = count($restaurant->carts);
            $scores = $restaurant->carts->map(fn($cart) => $cart->comments->first()->score ?? 0)->sum();
            $restaurant->update([
                'score' => $scores / $count
            ]);
        }

    }

}
