<?php

namespace App\Models\Restaurant;

use App\Http\Requests\Restaurant\RestaurantFilterRequest;
use App\Models\Cart\Cart;
use App\Models\Food\Food;
use App\Models\Schedule\RestaurantSchedule;
use App\Models\Schedule\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'cost_of_sending_order'
    ];

    public static function filterApi(RestaurantFilterRequest $request)
    {
        $query = Restaurant::query();
        $typeFilter = $request->input('type');
        $is_openFilter = $request->input('is_open');
        $sort = $request->input('sort', 'score');
        $restaurantCategoryId = RestaurantCategory::query()->where('name', 'like', '%' . $typeFilter . '%')->first()->id;
        if ($typeFilter) {
            return $query->where('restaurant_category_id', $restaurantCategoryId);
        } elseif ($is_openFilter !== null) {
            return $query->where('status', $is_openFilter ? 1 : 0);
        } elseif
        ($sort) {
            return $query->orderBy($sort, 'desc');
        }
        return $query;
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
}
