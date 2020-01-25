<?php
namespace core;

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    public function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $controllerName = ucfirst(array_shift($segments)).'Controller';
                $controllerClassName = '\\application\\controllers\\'.$controllerName;
                $actionName = array_shift($segments);
                $parameters = $segments;
                $controllerObject = new $controllerClassName;
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                if ($result) {
                    break;
                }
            }
        }
    }
}
