<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;
use Article_model;
use DateTimeImmutable;
use InvalidArgumentException;
use Token_model;
use User_model;

class AuthService
{
    private User_model $userModel;
    private Article_model $articleModel;
    private Token_model $tokenModel;

    public function __construct()
    {
        $this->userModel = new User_model();
        $this->articleModel = new Article_model();
        $this->tokenModel = new Token_model();
    }
    public function verify(UserDTO $user)
    {
        try{
            $registredUser = $this->userModel->findByEmail($user->email);
        }catch(InvalidArgumentException){
            throw new InvalidArgumentException('Email or password invalid');
        }

        $hash = $registredUser->password;

        $result = $user->password->compare($hash);

        if (!$result) {
            throw new InvalidArgumentException('Email or password invalid');
        }

        $tokenHasExists = $this->tokenModel->findByUserEmail($registredUser->email);

        if($tokenHasExists){
            $token = [
                'user_id' => $tokenHasExists->user_id,
                'token' => $tokenHasExists->token,
                'expiration' => $tokenHasExists->expiration
            ];

            return $token;
        }

        $tokenText = bin2hex(random_bytes(64));
        $expiration = new DateTimeImmutable('+1 hour');

        $token = [
            'user_id' => $registredUser->id,
            'token' => $tokenText,
            'expiration' => $expiration->format('Y-m-d H:i:s')
        ];

        $this->tokenModel->create($token);

        return $token;
    }
}