<?php

namespace App\Models\Cart;

use App\Models\Food\Food;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartFood extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'food_id',
        'food_count'
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
