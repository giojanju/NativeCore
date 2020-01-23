<?php

namespace App\Lib;

class Route
{
    private $get;

    public function __construct(string $get)
    {
        $this->get = $get;
    }

    public function get(string $url, $controller, string $method = 'index')
    {
        if ($this->get !== $url) {
            return false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (is_callable($controller) && !is_string($controller)) {
                return $controller();
            }

            $controllerObject = new $controller;
            if (!method_exists($controllerObject, $method)) {
                return error(sprintf('Method %s not found instance %s object',  $method, $controller));
            }

            return $controllerObject->{$method}();
        }

        return error('Method not allowed', 405);
    }

    public function post(string $url, $controller, string $method = 'index')
    {
        if ($this->get !== $url) {
            return false;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (is_callable($controller) && !is_string($controller)) {
                return $controller();
            }

            $controllerObject = new $controller;
            if (!method_exists($controllerObject, $method)) {
                return error(sprintf('Method %s not found instance %s object',  $method, $controller));
            }

            return $controllerObject->{$method}($_POST);
        }

        return error('Method not allowed', 405);
    }
}
