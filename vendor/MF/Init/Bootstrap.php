<?php

namespace MF\Init;

abstract class Bootstrap {

    private $routes;

    abstract protected function initRoutes();

    public function __construct() {
        $this->initRoutes();
        $this->run($this->getUrl());
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function setRoutes(array $routes) {
        $this->routes = $routes;
    }

    protected function run($url) {

        //echo "************" . $url . "************"; -> Verificando como o path está sendo retornado

        foreach ($this->getRoutes() as $key => $route) {

            //print_r($route);
            //echo '<br><br><br><br>'; -> Verificando se o retorno está sendo individual de cada route, precisamos testar separadamente

            if($url == $route['route']) {
                $class = "App\\Controllers\\" . $route['controller'];

                $controller = new $class;

                $action = $route['action'];

                $controller->$action();


            }
        }
    }

    protected function getUrl() {

        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        //return parse_url('www.google.com/gmail?x=10', PHP_URL_PATH);

    }

}


?>