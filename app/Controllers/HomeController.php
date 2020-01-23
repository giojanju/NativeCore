<?php

namespace App\Controllers;

use App\Lib\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('index', ['title' => 'Customer register']);
    }
}
