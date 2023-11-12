<?php

namespace App\Http\Requests\Comment;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCommentRequest extends FormRequest
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
            'cart_id' => ['required', 'numeric'],
            'content' => ['required', 'string','max:255'],
            'score' => ['required', 'numeric', 'between:1,5']
        ];
    }
    public function bodyParameters()
    {
        return [
            'cart_id' => [
                'description' => 'ID of the cart associated with the comment.',
                'example' => 1,
            ],
            'content' => [
                'description' => 'Content of the comment.',
                'example' => 'This is a great restaurant!',
            ],
            'score' => [
                'description' => 'Score or rating for the comment (between 1 and 5).',
                'example' => 5,
            ],
        ];
    }

}
