<?php

namespace app\core\requests\articles;

use app\core\Request;
use app\helpers\Exceptions\ValidationException;

class ArticleDeleteRequest extends Request
{
    public function validate($form)
    {
        $form->set_rules('id', 'Article ID', 'required|max_length[50]');

        if ($form->run() == FALSE) {
            $errors = $form->error_array();
            throw new ValidationException($errors);
        }
    }
}