<?php

namespace app\core\requests\articles;

use app\core\Request;
use app\helpers\Exceptions\ValidationException;

class ArticleUpdateRequest extends Request
{
    public function validate($form)
    {
        $form->set_rules('id', 'Article ID', 'required');
        $form->set_rules('title', 'Title', 'required|max_length[50]');
        $form->set_rules('content', 'Content', 'required');
        $form->set_rules('_method', 'Method', 'required');

        if ($form->run() == FALSE) {
            $errors = $form->error_array();
            throw new ValidationException($errors);
        }
    }
}