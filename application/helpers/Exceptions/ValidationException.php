<?php

namespace app\helpers\Exceptions;

class ValidationException extends \Exception
{
    protected array $errors;

    public function __construct(array $errors, $message = "Erro de validação", $code = 422)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}