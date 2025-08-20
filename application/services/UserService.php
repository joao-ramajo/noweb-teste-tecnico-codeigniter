<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;
use app\helpers\Exceptions\EntityNotFound;
use app\helpers\ValuesObjects\Token;
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

    public function findUserByTokn(Token $token)
    {
        $user = $this->userModel->findByToken($token);

        if(!$user){
            throw new EntityNotFound('No records found');
        }

        return $user;
    }
}