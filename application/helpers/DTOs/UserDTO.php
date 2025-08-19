<?php

namespace app\helpers\DTOs;

use app\core\Request;
use InvalidArgumentException;

class UserDTO
{
    public string $name;
    public string $password;
    public string $email;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(Request $request)
    {
        if($request->input('password') != $request->input('password_confirmation')){
            throw new InvalidArgumentException('The password has to be equals');
        }
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