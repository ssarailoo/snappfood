<?php

namespace App\Models\Restaurant;

use App\Casts\NameCast;
use App\Http\Requests\Restaurant\RestaurantFilterRequest;
use App\Models\Cart\Cart;
use App\Models\Comment;
use App\Models\Food\Food;
use App\Models\Image;
use App\Models\Schedule\RestaurantSchedule;
use App\Models\Schedule\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'restaurant_category_id',
        'address',
        'telephone',
        'bank_account_number',
        'longitude',
        'latitude',
        'cost_of_sending_order',
        'score'
    ];
protected $casts=[
    'cast'=>NameCast::class
];
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public static function filterApi(RestaurantFilterRequest $request ,$restaurants)
    {
        $query = Restaurant::query();
        if ($typeFilter = $request->input('type')) {
            $restaurantCategoryId = RestaurantCategory::query()->where('name', 'like', '%' . $typeFilter . '%')->first()->id;
           $restaurants->where('restaurant_category_id', $restaurantCategoryId);
        }

        if ($is_openFilter = $request->input('is_open')) {
            $restaurants->where('status', $is_openFilter ? 1 : 0);
        }

        if ($sort = $request->input('sort')) {
           $restaurants->orderBy($sort, 'desc');
        }
        return $restaurants;
    }


    public function scopeNearBy($query, $lat, $lon, $radius =4)
    {
        $haversine = "(6371 * acos(cos(radians($lat))
            * cos(radians(latitude))
            * cos(radians(longitude) - radians($lon))
            + sin(radians($lat))
            * sin(radians(latitude))))";
        return $query
            ->select()           // add here the columns you need, all columns: '*'
            ->selectRaw("{$haversine} AS distance")
            ->whereRaw("{$haversine} < ?", [$radius])
            ->orderBy('distance','asc');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function foods(): HasMany
    {
     return $this->hasMany(Food::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function restaurantCategory(): BelongsTo
    {
        return $this->belongsTo(RestaurantCategory::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function restaurantSchedules(): HasMany
    {
        return $this->hasMany(RestaurantSchedule::class);

    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class);
    }
    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Cart::class, 'restaurant_id', 'cart_id');
    }
}
