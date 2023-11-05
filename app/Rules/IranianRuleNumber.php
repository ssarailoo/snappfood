<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class IranianRuleNumber implements Rule
{


    public function passes($attribute, $value)
    {
        // Define the regex pattern
        $pattern = '/^(0|0098|\+98)9(0[1-5]|[1 3]\d|2[0-2]|98)\d{7}$/';

        // Use preg_match to check if the value matches the pattern
        return preg_match($pattern, $value);
    }
    public function message()
    {
        return 'The :attribute is not a valid Iranian phone number.';
    }
    public static function docs(): array
    {
        return [
            'description' => 'The data must be a valid Iranian phone number',
            'example' => '09122222222', // Only used if no other supported rules are present
        ];
    }

}
