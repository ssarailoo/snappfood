<?php

namespace App\Http\Requests\Restaurant;

use App\Models\Restaurant\RestaurantCategory;
use Illuminate\Foundation\Http\FormRequest;

class RestaurantFilterRequest extends FormRequest
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
            'type' => ['string'],
            'is_open' => ['boolean'],
            'sort' => ['in:score,name'],
            'restaurant_category_id' => [
                'in:' . implode(',', RestaurantCategory::query()->pluck('id')->toArray())
            ]
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'type' => [
                'description' => 'The type of restaurant (string).',
                'example' => 'Fast Food',
            ],
            'is_open' => [
                'description' => 'Flag to filter open/closed restaurants (boolean).',
                'example' => true,
            ],
            'sort' => [
                'description' => 'Desc Sorting option (string).',
                'example' => 'score',
            ],
        ];
    }
}
