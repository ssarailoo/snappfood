<?php

namespace App\Models\Cart;

use App\Http\Requests\Cart\StoreCartRequest;
use App\Models\Food\Food;
use App\Models\Restaurant\Restaurant;
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
        'total'
    ];

    public static function updateTotal($request, $cart)
    {

        $foods = $cart->foods;
        $count = $request->food_count;
        $total = $foods->reduce(function ($carry, $food) use ($count) {
            $pricePerItem = $food->price * (100 - $food->discount) / 100;
            return $carry + ($pricePerItem * $count);
        }, 0);
        $cart->update([
            'total' => $total
        ]);

    }

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
}
