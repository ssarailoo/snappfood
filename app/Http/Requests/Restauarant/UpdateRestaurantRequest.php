<?php

namespace App\Http\Requests\Restauarant;

use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRestaurantRequest extends FormRequest
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
            'name'=>['required',Rule::unique('restaurants')->ignore($this->route('restaurant')->id),'string'],
            'telephone'=>['required',Rule::unique('restaurants')->ignore($this->route('restaurant')->id),'size:8'],
            'address'=>['required','string'],
            'bank_account_number'=>['required','string','size:13'],
            'restaurant_category_id'=>['required'],
        ];
    }
}
