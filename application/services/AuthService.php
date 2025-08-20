<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;
use Article_model;
use DateTimeImmutable;
use InvalidArgumentException;
use User_model;

class AuthService
{
    private User_model $userModel;
    private Article_model $articleModel;

    public function __construct()
    {
        $this->userModel = new User_model();
        $this->articleModel = new Article_model();
    }
    public function verify(UserDTO $user)
    {
        try{
            $registredUser = $this->userModel->findByEmail($user->email);
        }catch(InvalidArgumentException){
            throw new InvalidArgumentException('Invalid login');
        }

        $hash = $registredUser->password;

        $result = $user->password->compare($hash);

        if (!$result) {
            throw new InvalidArgumentException('Email or password invalid');
        }

        $token = bin2hex(random_bytes(64));
        $expiration = new DateTimeImmutable('+1 hour');

        $payload = [
            'token' => $token,
            'expiration' => $expiration
        ];

        print_r($payload);
        die();
    }
}