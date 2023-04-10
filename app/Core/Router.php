<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Class Router
 *
 * @package App\core
 */
class Router
{
    public Application $app;
    /**
     * @var Request
     */
    public Request $request;
    /**
     * @var Response
     */
    public Response $response;
    /**
     * @var array
     */
    private array $routes = [];

    private array $middlewares = [];

    /**
     * Router constructor
     *
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param Application $app
     * @return void
     */
    public function setApp(Application $app): void
    {
        $this->app = $app;
    }

    /**
     * @return Application
     */
    public function getApp(): Application
    {
        return $this->app;
    }

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function post($path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function delete($path, $callback): void
    {
        $this->routes['delete'][$path] = $callback;
    }
    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function put($path, $callback): void
    {
        $this->routes['put'][$path] = $callback;
    }

    /**
     * @return mixed|null
     */
    public function resolve(): mixed
    {
        $uri_path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$uri_path] ?? false;
        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            $this->getApp()->controller = new $callback[0]();
            $callback[0] = $this->getApp()->controller;
        }
        foreach ($callback[0]->middlewares as $middleware) {
            (new $middleware())->execute($this->request);
        }
        return call_user_func($callback, $this->request, $this->getApp()->getUser());
    }

    /**
     * @param $view
     * @return void
     */
    private function renderView($view): void
    {
        include_once "./views/pages/$view.php";
    }
}
