<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'schedule_id'
    ];


    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
