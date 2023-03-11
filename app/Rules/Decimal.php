<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Decimal implements Rule
{
    private $minDecimalPlaces, $maxDecimalPlaces;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($minDecimalPlaces, $maxDecimalPlaces)
    {
        $this->minDecimalPlaces = $minDecimalPlaces;
        $this->maxDecimalPlaces = $maxDecimalPlaces;
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
        return preg_match("/^-?\d{0,9}(?:[.,]\d{{$this->minDecimalPlaces},{$this->maxDecimalPlaces}})?$/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Minimum ' . $this->minDecimalPlaces . ' and maximum ' . $this->maxDecimalPlaces . ' decimal places allowed in :attribute';
    }
}
