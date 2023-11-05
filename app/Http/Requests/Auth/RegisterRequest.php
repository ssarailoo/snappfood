<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Rules\IranianRuleNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone_number' => ['required','unique:users', new IranianRuleNumber()],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'The name of the user.',
                'example' => 'Saeed',
            ],
            'email' => [
                'description' => 'The email of the user.',
                'example' => 'saeed@example.com',
            ],

            'password' => [
                'description' => 'The user\'s password.',
                'example'=>'ss123456'
            ],

        ];
    }
}
