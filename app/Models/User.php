<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Address\Address;
use App\Models\Address\AddressUser;
use App\Models\Cart\Cart;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'current_address'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

        'password' => 'hashed',
    ];

    public function routeNotificationForKavenegar($driver, $notification = null)
    {
        return $this->phone_number;
    }

    public function restaurant(): HasOne
    {
        return $this->hasOne(Restaurant::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function addressUsers(): HasMany
    {
        return $this->hasMany(AddressUser::class, 'user_id', 'id');
    }

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function currentAddress()
    {
        return $this->belongsTo(Address::class,'current_address','id');
    }

}
