<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PossessionStateValues implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $available_values = [
            'empty',
            'own',
            'to_own',
        ];

        return in_array($value, $available_values);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.possession_state_values');
    }
}
