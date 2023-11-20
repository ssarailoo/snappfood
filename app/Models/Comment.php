<?php

namespace App\Models;

use App\Models\Cart\Cart;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'parent_id',
        'content',
        'score',
        'status'
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }


}
