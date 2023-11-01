<?php

namespace App\Models\Food;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodCategory extends Model
{
    use HasFactory;


    protected $fillable=[
        'name'
    ];
    public function foods(): HasMany
    {
        return $this->hasMany(Food::class);
    }

}
