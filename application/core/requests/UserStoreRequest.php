<?php

namespace app\core\requests;

use app\core\Request;
use app\helpers\Exceptions\ValidationException;
use InvalidArgumentException;

class UserStoreRequest extends Request
{
    public function validate($form)
    {
        $form->set_rules('email', 'E-mail', 'required|max_length[50]');
        $form->set_rules('name', 'Name', 'required|max_length[50]');
        $form->set_rules('password', 'Password', 'required|min_length[6]|max_length[12]');
        $form->set_rules('password_confirmation', 'Password Confirm', 'required|min_length[6]|max_length[12]');

        if ($form->run() == FALSE) {
            $errors = $form->error_array();
            throw new ValidationException($errors);
        }
    }
}

