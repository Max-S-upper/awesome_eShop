<?php
namespace application\components;
use application\controllers\StorageController as StorageController;

use application\controllers\UserController as UserController;

use application\controllers\AuthorizationController as AuthorizationController;

class Router {
    private $routes;

    public function __construct() {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    public function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run() {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $controllerName = ucfirst(array_shift($segments)).'Controller';
                $actionName = array_shift($segments);
                $controllerFile = ROOT."/application/controllers/$controllerName.php";
                $parameters = $segments;
//                if (file_exists($controllerFile)) {
//                    include_once($controllerFile);
//                }

                switch ($controllerName) {
                    case 'StorageController':
                        $controllerObject = new StorageController();
                        break;
                    case 'UserController':
                        $controllerObject = new UserController();
                        break;
                    case 'AuthorizationController':
                        $controllerObject = new AuthorizationController();
                        break;
                }

//                $controllerObject = new $controllerName;

                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                if ($result) {
                    break;
                }
            }
        }
    }
}