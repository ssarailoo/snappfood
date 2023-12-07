<?php

namespace App\Http\Requests\Cart;

use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use App\Models\Restaurant\Restaurant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
$current=Auth::user()->currentAddress;
$foods= $current!==null? Restaurant::query()->nearBy($current->latitude,$current->longitude)->get()->map(fn($restaurant)=>$restaurant->foods)->flatMap->pluck('id'):Food::all()->pluck('id');



            if ($foodParty=FoodParty::query()->find($this->post('food_party_id')))
            return [
                'food_id' => ['required_without:food_party_id', 'nullable', 'numeric', "in:" . implode(',', $foods->toArray())],
                'food_party_id' => ['required_without:food_id', 'nullable', 'numeric', "in:" . implode(',', FoodParty::query()->pluck('id')->toArray())],
                'food_count' => ['required', 'numeric', 'between:1,' .   (int)$foodParty->quantity],
            ];


        $foodParty = FoodParty::query()->where('food_id', $this->post('food_id'))->first();
        if ($foodParty !== null) {
            return [
                'food_id' => ['required_without:food_party_id', 'nullable', 'numeric', "in:" . implode(',',$foods->toArray())],
                'food_count' => ['required', 'numeric', 'between:1,' . (int)$foodParty->quantity],
                'food_party_id' => ['required_without:food_id', 'nullable', 'numeric', "in:" . implode(',', FoodParty::query()->pluck('id')->toArray())]
            ];
        }
        return [
            'food_id' => ['required_without:food_party_id', 'nullable', 'numeric', "in:" . implode(',', $foods->toArray())],
            'food_count' => ['required', 'numeric','min:1'],
            'food_party_id' => ['required_without:food_id', 'nullable', 'numeric', "in:" . implode(',', FoodParty::query()->pluck('id')->toArray())]
        ];
    }

}
