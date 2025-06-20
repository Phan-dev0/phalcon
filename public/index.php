<?php

use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Autoload\Loader;
use Phalcon\Mvc\Router;


$di = new FactoryDefault();

$loader = new Loader();
$loader->setNamespaces([
    'App\Frontend'  => __DIR__ . '/../app/frontend/',
    'App\Backend'   => __DIR__ . '/../app/backend/',
]);
$loader->register();


// if (!class_exists('App\Backend\Controllers\IndexController')) {
//     die('Backend IndexController NOT FOUND');
// } else {
//     die('Backend IndexController FOUND');
// }

$di->setShared('router', function () {
    $router = new Router(false);

    // Frontend (default)
    $router->add('/:controller/:action/', [
        'module'     => 'frontend',
        'controller' => 1,
        'action'     => 2,
    ]);

    $router->add('/', [
        'module'     => 'frontend',
        'controller' => 'index',
        'action'     => 'index',
    ]);

    // Backend (access via /admin)
    $router->add('/admin/:controller/:action/', [
        'module'     => 'backend',
        'controller' => 1,
        'action'     => 2,
    ]);

    $router->add('/admin', [
        'module'     => 'backend',
        'controller' => 'index',
        'action'     => 'index',
    ]);
    // 404 handler
    $router->notFound([
        'module'     => 'frontend',
        'controller' => 'error',
        'action'     => 'notFound',
    ]);

   
    return $router;
});

$app = new Application($di);

$app->registerModules([
    'frontend' => [
        'className' => 'App\Frontend\Module',
        'path'      => '../app/frontend/Module.php',
    ],
    'backend' => [
        'className' => 'App\Backend\Module',
        'path'      => '../app/backend/Module.php',
    ]
]);

try {
    
    $response = $app->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
