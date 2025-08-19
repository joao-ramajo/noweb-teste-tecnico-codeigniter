<?php

namespace app\helpers\DTOs;

use app\core\Request;
use app\helpers\ValuesObjects\Email;
use app\helpers\ValuesObjects\Password;
use stdClass;

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

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['password']
        );
    }

    public static function fromObject(stdClass $user): self
    {
        return new self(
            $user->name,
            $user->email,
            $user->password,
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