<?php

namespace App\Models;

use App\Casts\ImageCast;
use App\Http\Requests\Food\StoreFoodRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'food_category_id',
        'name',
        'materials',
        'price',
        'image',
        'discount',
        'status'
    ];
    protected $casts = [
        'image' => ImageCast::class
    ];


    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function foodCategory(): HasOne
    {
        return $this->hasOne(FoodCategory::class);
    }

    public function cartFoods(): HasMany
    {
        return $this->hasMany(CartFood::class);
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_food');
    }
    public function foodParties(): HasMany
    {
        return $this->hasMany(FoodParty::class, 'food_id');
    }

//    public function setImageAttribute($image)
//    {
//        // Check if an image was provided
//        if ($image) {
//            $imagePath = $image->store('public/images');
//            $this->attributes['image'] = $imagePath;
//        }
//    }

}
