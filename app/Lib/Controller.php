<?php

namespace App\Lib;

abstract class Controller
{
    private $viewPath = 'views';

    public function view(string $view, array $data = [])
    {
        $viewPath = '../' . $this->viewPath . '/' . $view . '.php';

        if (file_exists($viewPath)) {
            return include_once $viewPath;
        }

        return error(sprintf('View {%s} not found', $viewPath));
    }
}
