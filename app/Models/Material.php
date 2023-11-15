<?php

namespace App\Models;

use App\Models\Food\Food;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    use HasFactory;
    protected $fillable=[
        'name'
    ];

    /**
     * @return BelongsToMany
     */
    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class);
    }
}
