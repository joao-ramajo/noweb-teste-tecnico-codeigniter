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
        // $registedUser = 
        echo "Logando";
    }
}