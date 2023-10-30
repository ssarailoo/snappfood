<?php

namespace App\Http\Requests\FoodParty;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFoodPartyRequest extends FormRequest
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
            'discount' => ['required', 'numeric', 'between:1,100'],
            'quantity' => ['required', 'numeric', 'between:1,1000']
        ];
    }
}
