<?php

namespace App\Http\Requests\Comment;

use App\Models\Food\Food;
use App\Models\Restaurant\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

class GetCommentsRequest extends FormRequest
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
            'restaurant_id' => [ 'numeric', 'in:' . implode(',', Restaurant::query()->pluck('id')->toArray())],
                'food_id' => [ 'numeric', 'in:' . implode(',', Food::query()->pluck('id')->toArray())],
            'at_least_one_parameter' =>[ 'required_without_all:restaurant_id,food_id'],
        ];

    }

}
