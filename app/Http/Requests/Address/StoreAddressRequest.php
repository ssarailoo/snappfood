<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'address' => ['required', 'string'],
            'longitude' => ['required', 'numeric', 'between:-90.000000000000,90.000000000000'],
            'latitude' => ['required', 'numeric', 'between:-90.000000000000,90.000000000000'],
        ];
    }
}
