<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    public View $view;
    private Request $request;
    private Response $response;
    protected array $routeMap = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $url, $callback)
    {
        $this->routeMap['get'][$url] = $callback;
    }

    public function post(string $url, $callback)
    {
        $this->routeMap['post'][$url] = $callback;
    }

    public function delete(string $url, $callback)
    {
        $this->routeMap['get'][$url] = $callback;
    }


    public function getRouteMap($method): array
    {
        return $this->routeMap[$method] ?? [];
    }



    public function getCallback()
    {
        $method = $this->request->getMethod();
        $url = trim($this->request->getUrl(), '/');
        $routes = $this->getRouteMap($method);

        foreach ($routes as $route => $callback) {
            $route = trim($route, '/');

            if (empty($route)) {
                continue;
            }

            $routeRegex = "@^" . preg_replace_callback('/\{(\w+)(:[^}]+)?}/', function ($matches) {
                    return isset($matches[2]) ? "({$matches[2]})" : '(\w+)';
                }, $route) . "$@";

            if (preg_match($routeRegex, $url, $valueMatches)) {
                preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches);
                $routeNames = $matches[1];

                $values = array_slice($valueMatches, 1);
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return false;
    }
    public function resolve()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        $callback = $this->routeMap[$method][$url] ?? false;
        if (!$callback) {
            $callback = $this->getCallback();

            if ($callback === false) {
                throw new NotFoundException();
            }
        }

        if (is_string($callback)) {
            return $this->view->renderView($callback);
        }

        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = new Application::$app->controller();
        }
        return call_user_func($callback, $this->request, $this->response);
    }
}
