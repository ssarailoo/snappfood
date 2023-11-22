<?php

namespace App\Http\Requests\Cart;

use App\Models\Food\Food;
use App\Models\Food\FoodParty;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'food_id' => ['required_without:food_party_id','nullable', 'numeric',"in:".implode(',',Food::query()->pluck('id')->toArray())],
            'food_count' => ['required', 'numeric', 'between:1,100'],
            'food_party_id' => ['required_without:food_id', 'nullable', 'numeric',"in:".implode(',',FoodParty::query()->pluck('id')->toArray())]
        ];
    }

}
