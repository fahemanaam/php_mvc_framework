<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    public array $routes = [];
    public Request $request;
    public Application $app;
    public Response $response;
    public View $view;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response,View $view)
    {
        $this->request = $request;
        $this->response= $response;
        $this->view= $view;
    }
    public function get($path, $callback)
    {
        return $this->routes['get'][$path]= $callback;
    }

    public function post($path, $callback)
    {
        return $this->routes['post'][$path]= $callback;
    }

    public function  resolve(){
        $path = $this->request->getpath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if (is_string($callback)){
            return $this->view->renderView($callback);
        }
        if ($callback === false){

            throw new NotFoundException();
        }

        if (is_string($callback)){
            return $this->view->renderView($callback);
        }

        if (is_array($callback)){
            /** @var Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller =$controller ;

            $controller->action= $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();

            }

        }

        return call_user_func($callback,$this->request,$this->response);

    }

}