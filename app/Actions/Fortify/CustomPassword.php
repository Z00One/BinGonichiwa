<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password as FortifyPassword;

class CustomPassword extends FortifyPassword
{
    /**
     * The minimum length of the password.
     *
     * @var int
     */
    protected $length = 5;

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->message) {
            return $this->message;
        }

        return __('messages.custom_password_messages.default', [
            'length' => $this->length,
            'attribute' => __('messages.auth.password'),
        ]);
    }
}
