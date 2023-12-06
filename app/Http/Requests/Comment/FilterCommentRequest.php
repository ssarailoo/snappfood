<?php

namespace App\Http\Requests\Comment;

use App\Enums\CommentStatus;
use App\Models\Food\Food;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FilterCommentRequest extends FormRequest
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
        if (Auth::user()->hasRole('restaurant-manager')) {
            $foodIds = $this->route()->parameter('restaurant')->foods->pluck('id')->toArray();
            return [
                'status' => ['nullable', 'in:' . implode(',', CommentStatus::getValues())],
                'food' => ['nullable', 'in:' . implode(',', $foodIds)],
            ];
        }
        return [
            'status' => ['nullable', 'in:' . implode(',', CommentStatus::getValues())],
            'food' => ['nullable', 'in:' . implode(',', Food::all()->pluck('id')->toArray())],
        ];
    }
}
