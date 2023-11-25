<?php

namespace App\Http\Requests\Cart;

use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCartRequest extends FormRequest
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

            if ($foodParty=FoodParty::query()->find($this->post('food_party_id')))
            return [
                'food_party_id' => ['bail','required_without:food_id', 'nullable', 'numeric', "in:" . implode(',', FoodParty::query()->pluck('id')->toArray())],
                'food_count' => ['required', 'numeric', 'max:' .   (int)$foodParty->quantity],
            ];

        $foodParty = FoodParty::query()->where('food_id', $this->post('food_id'))->first();
        if ($foodParty !== null) {
            return [
                'food_id' => ['required_without:food_party_id', 'nullable', 'numeric', "in:" . implode(',', Food::query()->pluck('id')->toArray())],
                'food_count' => ['required', 'numeric', "max:" . (int)$foodParty->quantity],
                'food_party_id' => ['required_without:food_id', 'nullable', 'numeric', "in:" . implode(',', FoodParty::query()->pluck('id')->toArray())]
            ];
        }
        return [
            'food_id' => ['required_without:food_party_id', 'nullable', 'numeric', "in:" . implode(',', Food::query()->pluck('id')->toArray())],
            'food_count' => ['required', 'numeric'],
            'food_party_id' => ['required_without:food_id', 'nullable', 'numeric', "in:" . implode(',', FoodParty::query()->pluck('id')->toArray())]
        ];
    }

}
