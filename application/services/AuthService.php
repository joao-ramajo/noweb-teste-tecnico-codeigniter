<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;
use Article_model;
use InvalidArgumentException;
use Token_model;
use User_model;

class AuthService
{
    private User_model $userModel;
    private TokenService $tokenService;

    public function __construct()
    {
        $this->userModel = new User_model();
        $this->tokenService = new TokenService();
    }

    public function login(UserDTO $user)
    {
        $registredUser = $this->userModel->findByEmail($user->email);

        $result = $user->password->compare($registredUser->password);

        if (!$result) {
            throw new InvalidArgumentException('Email or password invalid');
        }

        $token = $this->tokenService->generateToken($user->email, $registredUser->id);

        return $token;
    }

    public function logout($token)
    {
        // apaga token
        
        // retorno
    }
}