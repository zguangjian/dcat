<?php

namespace App\Rules;

use App\Extension\IdentityCard;
use Illuminate\Contracts\Validation\Rule;

class IdentityCardRule implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return IdentityCard::isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '身份证格式错误';
    }
}
