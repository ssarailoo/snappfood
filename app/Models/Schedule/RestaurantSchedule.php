<?php

namespace App\Models\Schedule;

use App\Models\Restaurant\Restaurant;
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
    protected $table = 'restaurant_schedule';


    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
