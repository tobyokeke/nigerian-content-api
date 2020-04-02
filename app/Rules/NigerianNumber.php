<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NigerianNumber implements Rule
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
        $firstNumber = str_split($value, 1)[0];
        if(strlen($value) == 11 and $firstNumber == 0 ) return true;
        else return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute should be an 11 digit nigerian number starting with a zero. Eg. 08081234567.';
    }
}
