<?php

namespace App\Models\Cart;

use App\Http\Requests\Cart\StoreCartRequest;
use App\Models\Comment;
use App\Models\Discount;
use App\Models\Food\Food;
use App\Models\Restaurant\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'total',
        'is_paid',
        'hashed_id',
        'status',
        'discount_id'
    ];

    public function cartFoods(): HasMany
    {
        return $this->hasMany(CartFood::class);

    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function getCartFoodsSyncData()
    {
        return    $this->cartFoods->map(function ($cartFood) {
            return [
                'food_id'=>$cartFood->food_id,
                'in_party' => $cartFood->in_party,
                'food_count' => $cartFood->food_count,
                'price' => $cartFood->price,
                'discount_percent' => $cartFood->discount_percent,
            ];
        })->toArray();
    }
}
