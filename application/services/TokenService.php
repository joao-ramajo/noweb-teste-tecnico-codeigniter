<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;
use app\helpers\ValuesObjects\Email;
use Article_model;
use DateTimeImmutable;
use InvalidArgumentException;
use Token_model;
use User_model;

class TokenService
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

    public function validateToken(){}
    public function generateToken(Email $userEmail, string $id)
    {
        // verifica se existe
        $tokenHasExists = $this->tokenModel->findByUserEmail($userEmail);

        if($tokenHasExists){
            $payload['user_id'] = $tokenHasExists->user_id;
            $payload['token'] = $tokenHasExists->token;
            $payload['expiration'] = $tokenHasExists->expiration;

            return $payload;
        }

        // se nao gera um novo
        $tokenText = bin2hex(random_bytes(64));
        $expiration = new DateTimeImmutable('+1 hour');

        $token = [
            'user_id' => $id,
            'token' => $tokenText,
            'expiration' => $expiration->format('Y-m-d H:i:s')
        ];

        // salva o token

        $this->tokenModel->create($token);

        // retorna o payload
        return $token;
    }
    public function revokeToken(){}
}