<?php

namespace App\Models;

use App\Models\Cart\Cart;
use App\Models\Food\Food;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FoodOrder extends Pivot
{
    protected $fillable = [
        'cart_id',
        'food_id',
        'food_count',
        'in_party'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
