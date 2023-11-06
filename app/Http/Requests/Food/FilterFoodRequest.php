<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 *
 */
class FilterFoodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @ignore
     * @hide
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sort_by' => [
                'in:name_asc,name_desc,price_asc,price_desc'
            ]
        ];
    }
}
