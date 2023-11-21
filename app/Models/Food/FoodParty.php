<?php

namespace App\Models\Food;

use App\Http\Requests\FoodParty\SetFoodPartyTimesRequest;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class FoodParty extends Model
{
    use HasFactory;

    protected $fillable=[

        'food_id',
        'discount',
        'quantity'
    ];

    public static function setTimes(SetFoodPartyTimesRequest $request)
    {
        if (DB::table('food_party_times')->first()) {
            DB::table('food_party_times')->where('id', 1)->update(
                $request->validated()
            );
        } else
            DB::table('food_party_times')->insert(
                $request->validated()
            );
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }


}
