<?php

require_once __DIR__ . '/../support/helper.php';
require __DIR__ . '/../vendor/autoload.php';

use App\Lib\Route;

$dotEnv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotEnv->load();

error_reporting(0);
if (getenv('APP_DEBUG')) {
    error_reporting(E_ALL);
}

$router = new Route($_GET['url'] ?? 'index');

require __DIR__ . '/../routes/web.php';

