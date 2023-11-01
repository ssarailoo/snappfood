<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RestaurantCategory extends Model
{
    use HasFactory;

    protected $fillable=[
        'name'
    ];

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }
}
