<?php

namespace App\Http\Requests\Order;

use App\Enums\CartStatus;
use Illuminate\Foundation\Http\FormRequest;

class FilterOrderByStatusRequest extends FormRequest
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
        $statuses=CartStatus::getValues();
        $last= array_key_last($statuses);
        unset($statuses[$last]);
        return [
          'filter_status'=>['sometimes','nullable',"in:".implode(',',$statuses)]
        ];
    }
}
