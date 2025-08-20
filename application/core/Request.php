<?php

namespace app\core;

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

    public function getToken()
    {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization']) ?? null;

        return $token;
    }
}