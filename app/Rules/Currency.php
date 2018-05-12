<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Currency implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^-?\d*(\.\d{'.config('app.currency_decimals', 2).'})?$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The field should be a valid currency e.g. 1000' . \Formatter::toStep(config('app.currency_decimals', 2)) . '.';
    }
}
