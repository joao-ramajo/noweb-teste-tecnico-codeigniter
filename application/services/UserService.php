<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;
use InvalidArgumentException;
use User_model;

class UserService
{
    private User_model $userModel;
    public function __construct()
    {
        $this->userModel = new User_model();
    }
    public function save(UserDTO $user)
    {
        $data = $user->toArray();
        if(!$user){
            throw new InvalidArgumentException('Nenhum parametro recebido');
        }

        $result = $this->userModel->create($user);
    }
}