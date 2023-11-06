<?php

namespace App\Http\Requests\Cart;

use App\Models\Food\Food;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'food_id' => ['required', 'numeric',"in:".implode(',',Food::query()->pluck('id')->toArray())],
            'food_count' => ['required', 'numeric', 'between:1,100'],
        ];
    }

}
