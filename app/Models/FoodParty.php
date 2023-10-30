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
        return $this->food->restaurant;
    }

    public function price()
    {
        return $this->food->price;
    }

    public function materials()
    {
        $this->food->materials;

    }

    public function image()
    {
        $this->food->image;
    }
}
