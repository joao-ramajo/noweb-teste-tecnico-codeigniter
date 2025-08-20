<?php

namespace app\helpers\ValuesObjects;

use InvalidArgumentException;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        if(strlen($password) <= 20)
        {
            $this->validate($password);
        }
        $this->password = $password;
    }

    public function __toString(): string
    {
        return $this->password;
    }

    public function compare($databasePassword): bool
    {
        return password_verify($this->password, $databasePassword);
    }

    public function hash(): string
    {
        return password_hash($this->password, PASSWORD_BCRYPT);
    }

    private function validate(string $password): void
    {
        if(strlen($password) < 6){
            throw new InvalidArgumentException('Password must be at least 6 characters long');
        }

        if(strlen($password) > 12){
            throw new InvalidArgumentException('Password cannot be longer than 12 characters');
        }

        if(!preg_match('/[A-Z]/', $password)){
            throw new InvalidArgumentException('Password must contain at least one uppercase letter');
        }

        if(!preg_match('/[a-z]/', $password)){
            throw new InvalidArgumentException('Password must contain at least one lowercase letter');
        }
    }
}