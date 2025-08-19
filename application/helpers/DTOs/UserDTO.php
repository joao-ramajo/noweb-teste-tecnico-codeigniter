<?php

namespace app\helpers\DTOs;

use app\core\Request;

class UserDTO
{
    public string $name;
    public string $password;
    public string $email;

    public function __construct(string $name, string $password, string $email)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(Request $request)
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
        );
    }
}