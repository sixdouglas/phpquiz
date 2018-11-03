<?php

namespace PhpQuiz;

class MethodCaller
{
    private $controller;
    private $method;

    public function __construct($controller, $method)
    {
        $this->controller = new $controller;
        $this->method = $method;
    }

    public function invoke($params)
    {
        return $this->method->invoke($this->controller, $params);
    }
}
