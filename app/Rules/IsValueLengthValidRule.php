<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsValueLengthValidRule implements ValidationRule
{
    protected $min;
    protected $max;
    protected $is_mbstring;

    /**
     * @param mixed $min
     * @param mixed $max
     * @param bool $is_mbstring
     */
    public function __construct($min, $max, $is_mbstring = false)
    {
        $this->min = $min;
        $this->max = $max;
        $this->is_mbstring = $is_mbstring;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * 
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $length = $this->is_mbstring ? mb_strlen($value) : strlen($value);

        if ($length < $this->min || $length > $this->max) {
            $fail("The :attribute must be between {$this->min} and {$this->max} characters.");
        }
    }
}
