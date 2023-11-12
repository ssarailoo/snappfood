<?php

namespace App\Models\Food;

use App\Casts\ImageCast;
use App\Models\Cart\Cart;
use App\Models\Cart\CartFood;
use App\Models\Image;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\Request;

class Food extends Model
{
    use HasFactory;

    protected $with = ['restaurant'];
    protected $table='foods';

    protected $fillable = [
        'restaurant_id',
        'food_category_id',
        'name',
        'materials',
        'price',
        'discount',
        'status'
    ];


    public static function getSortedFoods(Request $request, $foods)
    {
        if ($request->has('sort_by')) {
            $sortMethod = $request->get('sort_by');
            switch ($sortMethod) {
                case 'name_asc':
                    $foods->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $foods->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $foods->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $foods->orderBy('price', 'desc');
                    break;
            }
        }
        return $foods;
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function foodCategory(): BelongsTo
    {
        return $this->belongsTo(FoodCategory::class);
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

    public function scopeFoodsOf(Builder $builder, string $id): Builder
    {
        return $builder->where('restaurant_id', $id);

    }

    public function scopeFilterBy(Builder $builder, string $attribute, string $value)
    {
        return $builder->where($attribute, $value);
    }

}
