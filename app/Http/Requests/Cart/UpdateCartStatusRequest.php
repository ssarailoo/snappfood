<?php

namespace App\Http\Requests\Cart;

use App\Enums\CartStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartStatusRequest extends FormRequest
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
            'newStatus' =>[ 'required|in:' . implode(',', CartStatus::getValues())],
        ];
    }
}