<?php

namespace App\Models\Schedule;

use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_id',
        'start_time',
        'end_time',

    ];

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

    public function restaurantSchedules(): HasMany
    {
        return $this->hasMany(RestaurantSchedule::class);
    }

    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class);

    }
}
