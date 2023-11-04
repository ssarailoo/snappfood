<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddressUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id'
    ];
    protected $table='address_user';

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
