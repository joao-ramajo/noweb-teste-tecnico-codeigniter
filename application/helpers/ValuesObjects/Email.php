<?php

namespace app\helpers\ValuesObjects;

use InvalidArgumentException;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->validate($email);

        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    private function validate(string $email): void
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException('Invalid email format');
        }
    }
}