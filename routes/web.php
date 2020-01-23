<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;

$router->get('index', HomeController::class, 'index');
$router->post('insert', HomeController::class, 'insert');

$router->get('register', AuthController::class, 'index');
$router->post('register', AuthController::class, 'register');

$router->get('login', AuthController::class, 'login');
$router->post('auth', AuthController::class, 'auth');
