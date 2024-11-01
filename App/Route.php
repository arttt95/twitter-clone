<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

    protected function initRoutes() {

        $routes['home'] = [
            'route' => '/',
            'controller' => 'IndexController',
            'action' => 'index'
        ];

        $routes['inscreverse'] = [
            'route' => '/inscreverse',
            'controller' => 'IndexController',
            'action' => 'inscreverse'
        ];

        $routes['registrar'] = [
            'route' => '/registrar',
            'controller' => 'IndexController',
            'action' => 'registrar'
        ];

        $this->setRoutes($routes);


    }

}

?>