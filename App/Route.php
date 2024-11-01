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

        $this->setRoutes($routes);


    }

}

?>