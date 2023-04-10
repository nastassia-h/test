<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;
use Exception;
use stdClass;

/**
 * Class Application
 *
 * @package App\Core
 */
class Application
{
    /**
     * @var Application
     */
    public static Application $app;
    /**
     * @var Response
     */
    public Response $response;
    /**
     * @var Router
     */
    public Router $router;
    /**
     * @var Request
     */
    public Request $request;
    /**
     * @var Database
     */
    public Database $db;
    /**
     * @var ?DbModel
     */
    public ?DbModel $user;
    /**
     * @var Controller
     */
    public  Controller $controller;

    /**
     * @param $router
     * @param $database
     */
    public function __construct($router, $database)
    {
        self::$app = $this;
        $this->router = $router;
        $this->db = $database;
        $this->response = $this->router->response;
        $this->request = $this->router->request;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        try {
            $this->router->resolve();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param DbModel $user
     * @return true
     */
    public function login(DbModel $user): bool
    {
        $this->user = $user;
        $primary_key = $user->primaryKey();
        $primary_value = $user->{$primary_key};
        $_SESSION['user'] = $primary_value;
        $_SESSION['token'] = bin2hex(random_bytes(16));
        return true;
    }

    /**
     * @return DbModel
     */
    public function getUser(): DbModel
    {
        return $this->user;
    }

    /**
     * @param DbModel $user
     * @return void
     */
    public function setUser(DbModel $user): void
    {
        if (isset($_SESSION['user'])) {
            $primary_value = $_SESSION['user'];
            $primary_key = $user->primaryKey();
            $this->user = $user->findOne([$primary_key => $primary_value]);
            $this->user->setDatabase($this->db);
        } else {
            $this->user = $user;
        }
    }
}
