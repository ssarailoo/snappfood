<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'color'
    ];
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
