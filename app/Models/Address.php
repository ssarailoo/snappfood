<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'address',
        'user_id',
        'longitude',
        'latitude'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'

    ];
//    protected $appends = ['hashed_id']; // Append this attribute to the model's JSON representation
//
//    public function getHashedIdAttribute()
//    {
//        return Hash::make($this->attributes['id']);
//    }
    public function addressUser(): HasMany
    {
        return $this->hasMany(AddressUser::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
