<?php

namespace app\core;

class View
{
    public string $title = '';



    public function renderView($view , $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent =$this->layoutContent();
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    public function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        require_once Application::$DIR_ROOT."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view , $params)
    {
        foreach ($params as $key=>$value) {
            $$key=$value;
        }
        ob_start();
        require_once Application::$DIR_ROOT."/views/$view.php";
        return ob_get_clean();
    }
}