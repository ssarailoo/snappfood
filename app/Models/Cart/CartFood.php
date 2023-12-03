<?php

namespace App\Models\Cart;

use App\Models\Food\Food;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartFood extends Model
{
    use HasFactory,CascadeSoftDeletes,SoftDeletes;

    protected $fillable = [
        'cart_id',
        'food_id',
        'food_count',
        'in_party'
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
