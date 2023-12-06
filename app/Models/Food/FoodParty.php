<?php

namespace App\Models\Food;

use App\Http\Requests\FoodParty\SetFoodPartyTimesRequest;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            DB::table('food_party_times')->updateOrInsert(
                ['id' => 1],
                $request->validated()
            );
        }catch (QueryException $e){
            Log::error('Error Inserting new Food Party time'.$e->getMessage());
        }
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }


}
