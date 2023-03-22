<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *, Authorization');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');

use App\Services\Router;

use App\Services\App;

require_once __DIR__ . "/vendor/autoload.php";
App::start();
require_once __DIR__ . "/router/routes.php";
