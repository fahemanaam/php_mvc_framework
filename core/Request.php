<?php

namespace app\core;

class Request
{
    private array $routeParams = [];

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getUrl()
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    public function isGet(): bool
    {
        return $this->getMethod() === 'get';
    }

    public function isPost(): bool
    {
        return $this->getMethod() === 'post';
    }

    public function isDelete():bool
    {
        return $this->getMethod() === 'get';
    }

    public function getBody(): array
    {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                // Удаление символов &#13;&#10;
                $cleanedValue = str_replace(["\r", "\n"], '', $value);
                $decodedValue = htmlspecialchars_decode($cleanedValue, ENT_QUOTES);
                $filteredValue = filter_var($decodedValue, FILTER_SANITIZE_SPECIAL_CHARS);
                $data[$key] = htmlentities($filteredValue, ENT_QUOTES, 'UTF-8');
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                // Удаление символов &#13;&#10;
                $cleanedValue = str_replace(["\r", "\n"], '', $value);
                $decodedValue = htmlspecialchars_decode($cleanedValue, ENT_QUOTES);
                $filteredValue = filter_var($decodedValue, FILTER_SANITIZE_SPECIAL_CHARS);
                $data[$key] = htmlentities($filteredValue, ENT_QUOTES, 'UTF-8');
            }
        }

        return $data;
    }
    public function setRouteParams($params): Request
    {
        $this->routeParams = $params;
        return $this;
    }
    public function getRouteParam($param, $default = null)
    {
        return $this->routeParams[$param] ?? $default;
    }
}
