<?php

namespace App\Models\Restaurant;

use App\Models\Cart\Cart;
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

    public function getRouteKeyName()
    {
        return 'name';
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
