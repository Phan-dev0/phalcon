<?php
use Phalcon\Mvc\Router;

$router = new Router();

$router->add('/', [
    'controller' => 'home',
    'action'     => 'index'
]);

return $router;