<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'title' => ['required', 'string','max:255'],
            'address' => ['required', 'string','max:255'],
            'longitude' => ['required', 'numeric', 'between:-90.000000000000,90.000000000000'],
            'latitude' => ['required', 'numeric', 'between:-90.000000000000,90.000000000000'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'title' => [
                'description' => 'Title of the address.',
                'example'=>'home'
            ],
            'address' => [
                'description' => 'Address details.',
                'example'=>'Tehran , Sattar Khan st'
            ],
            'longitude' => [
                'description' => 'Longitude of the address coordinates.',
                'example'=>'50.0214'
            ],
            'latitude' => [
                'description' => 'Latitude of the address coordinates.',
                'example'=>'52.36'
            ],
        ];
    }
}
