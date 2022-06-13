<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'LogPluginColetores',
    ['path' => '/coletores'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->connect('/', ['controller' => 'Usuarios', 'action' => 'login']);
        $routes->connect('/coletor-maritimo/*', ['controller' => 'ColetorMaritimo', 'action' => 'index']);
    }
);
