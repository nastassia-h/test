<?php

use App\Services\Router;
use App\Controllers\AuthController;

Router::page('/register', 'register');
Router::post('/auth/register', AuthController::class, "register");


Router::enable();
