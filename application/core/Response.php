<?php

namespace app\core;

class Response
{
    public static function json($data, $code = 200): void
    {
        http_response_code($code);
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
}