<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;
use Article_model;
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
        $registredUser = $this->userModel->findByEmail($user->email);

        // print_r($registredUser);

        echo $registredUser->password;
        echo PHP_EOL . $user->password;

        if ($registredUser && $user->password->compare($registredUser->password)) {
            echo "Passwords match";
        } else {
            echo "Passwords do not match";
        }
        die();
    }
}