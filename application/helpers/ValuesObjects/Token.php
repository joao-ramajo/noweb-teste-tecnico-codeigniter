<?php

namespace app\helpers\ValuesObjects;

class Token
{
    private string $type;
    private string $token;

    public function __construct(array $content)
    {
        $this->type = $content[0];
        $this->token = $content[1];
    }

    public function __toString(): string
    {
        return $this->token;
    }
}