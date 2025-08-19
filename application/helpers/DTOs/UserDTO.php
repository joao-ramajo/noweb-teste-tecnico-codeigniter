<?php

namespace app\helpers\DTOs;

use app\core\Request;
use app\helpers\ValuesObjects\Email;
use app\helpers\ValuesObjects\Password;

class UserDTO
{
    public string $name;
    public Password $password;
    public Email $email;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = new Email($email);
        $this->password = new Password($password);
    }

    public static function fromRequest(Request $request)
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
        );
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}