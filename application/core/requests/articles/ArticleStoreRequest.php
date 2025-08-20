<?php

namespace app\core\requests\articles;

use app\core\Request;
use app\helpers\Exceptions\ValidationException;

class ArticleStoreRequest extends Request
{
    public function validate($form): void
    {
        $form->set_rules('title', 'Title', 'required|max_length[50]');
        $form->set_rules('content', 'Content', 'required');

        if ($form->run() == FALSE) {
            $errors = $form->error_array();
            throw new ValidationException($errors);
        }
    }
}