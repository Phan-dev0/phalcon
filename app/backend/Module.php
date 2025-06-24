<?php

namespace App\Backend;

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Autoload\Loader;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

class Module
{
    public function registerAutoloaders(DiInterface $di = null): void
    {
        $loader = new Loader();

        $loader->setNamespaces([
            'App\Backend\Controllers' => __DIR__ . '/controllers/',
            'App\Backend\Models'      => __DIR__ . '/models/',
            'App\Backend\Repositories' => __DIR__ . '/repositories/'
        ])->register();

        $loader->register();
    }

    public function registerServices(DiInterface $di): void
    {
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('App\Backend\Controllers');
            return $dispatcher;
        });

        $di->set('view', function () use ($di) {    
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');

            $view->registerEngines([
                '.volt' => function ($view) use ($di) {
                    $volt = new Volt($view, $di);
                    $volt->setOptions([
                        'always' => true, 
                    ]);
                    return $volt;
                }
            ]);

            return $view;
        });

        
    }
}
