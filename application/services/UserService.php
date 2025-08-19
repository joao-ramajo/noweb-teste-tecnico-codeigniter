<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;
use Exception;
use InvalidArgumentException;
use stdClass;
use User_model;

class UserService
{
    private User_model $userModel;

    public function __construct()
    {
        $this->userModel = new User_model();
    }

    public function save(UserDTO $user): stdClass
    {
        $data = $user->toArray();

        $pass = $user->password->hash();
        $data['password'] = $pass;

        $result = $this->userModel->create($data);

        if(!$result){
            throw new Exception('Failed to save user');
        }

        $created = $this->userModel->findByEmail($user->email);
        unset($created->password);

        return $created;
    }
}