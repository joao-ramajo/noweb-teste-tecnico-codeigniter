<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;
use Exception;
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

        $result = $this->userModel->create($data);

        if(!$result){
            throw new Exception('Failed to save user');
        }
    }
}