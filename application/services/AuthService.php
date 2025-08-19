<?php

namespace app\services;

use app\helpers\DTOs\UserDTO;

class AuthService
{
    public function verify(UserDTO $user)
    {
        echo "Logando";
    }
}