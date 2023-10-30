<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodParty extends Model
{
    use HasFactory;

    protected $fillable=[

        'food_id',
        'discount',
        'quantity'
    ];

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }

    public function restaurant()
    {
        return $this->hasOneThrough(Restaurant::class,Food::class,'restaurant_id','id');

}
}
