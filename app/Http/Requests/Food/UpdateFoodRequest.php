<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFoodRequest extends FormRequest
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
            'name' => ['required'],
            'materials' => ['required','array'],
            'materials.*' => ['string','max:255'],
            'price' => ['required','numeric'],
            'food_category_id' => ['required'],
            'discount'=>['required','between:0,100','numeric'],
            'status'=>['required','in:1,0'],
            'url' => ['sometimes', 'nullable',  'max:2048'],
        ];
    }
}
