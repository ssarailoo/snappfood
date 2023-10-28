<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'total'
    ];

    public function cartFoods(): HasMany
    {
        return $this->hasMany(CartFood::class);

    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class);
    }
}
