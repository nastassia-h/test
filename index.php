<?php

declare(strict_types=1);

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Models\User;
use App\Core\Application;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Core\Database;
use App\Middlewares\AuthMiddleware;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *, Authorization');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');

session_start();

require_once __DIR__ . '/vendor/autoload.php';

$request = new Request();

$response = new Response();

$database = new Database();

$router = new Router($request, $response);

$app = new Application($router, $database);

$user = new User();

$user->setDatabase($database);
$app->setUser($user);
$router->setApp($app);


/**
 *  Get methods
 */
$app->router->get('', 'dashboard');
$app->router->get('auth', 'auth');
$app->router->get('authLogout', [AuthController::class, 'logout']);
$app->router->get('users', [UserController::class, 'getUsers']);
$app->router->get('user', [UserController::class, 'show']);


/**
 *  Post methods
 */
$app->router->post('authLogin', [AuthController::class, 'login']);
$app->router->post('authRegister', [AuthController::class, 'register']);
$app->router->put('user', [UserController::class, 'update']);
/**
 *  Delete methods
 */
$app->router->delete('user', [UserController::class, 'delete']);

$app->run();
