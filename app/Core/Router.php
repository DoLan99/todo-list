<?php

namespace App\Core;

use App\Core\Request;
use App\Core\Response;
use App\Core\Application;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $params = [];

        foreach ($this->routes[$method] as $regex => $controller) {
            $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($regex)) . "$@D";
    
            if (preg_match_all($pattern, $path, $matches)) {
                $pathArr = explode('/', $path);
                foreach (explode('/', $regex) as $index => $param) {
                    if (preg_match("/\:.*/", $param)) {
                        $key = ltrim($param, ':');
                        $params[$key] = $pathArr[$index];
                        $path = $regex;
                    }
                }
            }
        }

        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            Application::$app->response->statusCode(404);
            return Application::$app->template->renderOnlyView('pages/_404');
        }

        if (is_string($callback)) {
            return Application::$app->template->render($callback);
        }

        if (is_array($callback)) {
            $controller = new $callback[0];
            $controller->action = $callback[1];
            Application::$app->controller = $controller;
            $callback[0] = $controller;
        }

        return call_user_func($callback, $params);
    }
}
