<?php

namespace app\core;

use app\helpers\Exceptions\InvalidTokenException;
use app\helpers\ValuesObjects\Token;

class Request
{
    protected $data;
    protected $params;
    protected $method;

    public function __construct($method = null, $data = null, $params = null)
    {
        if(is_null($method)){
            $method = $_SERVER['REQUEST_METHOD'];
        }

        if(is_null($data)){
            $data = $_POST;
        }

        if(is_null($params)){
            $params = $_GET;
        }

        $this->data = $data;
        $this->method = $method;
        $this->params = $params;
    }

    public function input($key)
    {
        return htmlspecialchars($this->data[$key], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public function method()
    {
        return $this->method;
    }

    public function getToken(): Token
    {
        $headers = getallheaders();
        $content = explode(' ', $headers['Authorization']) ?? null;

        if(!$content){
            throw new InvalidTokenException('Invalid header');
        }

        $token = new Token($content);

        return $token;
    }
}