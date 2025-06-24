<?php

namespace App\Frontend;

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Autoload\Loader;

class Module
{
    public function registerAutoloaders(DiInterface $di = null): void
    {
        //  error_log(__DIR__ . '/controllers/');
        $loader = new Loader();
        $loader->setNamespaces([
            'App\Frontend\Controllers' => __DIR__ . '/controllers/',
            'App\Frontend\Models'      => __DIR__ . '/models/',
            'App\Frontend\Repositories' => __DIR__ . '/repositories/'
        ]);
        $loader->register();
    }

    public function registerServices(DiInterface $di): void
    {
        $di->setShared('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('App\Frontend\Controllers');
            return $dispatcher;
        });

        $di->set('view', function () use ($di) {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');
            error_log(__DIR__ . '/views/');

            $view->registerEngines([
                '.volt' => function ($view) use ($di) {
                    $volt = new Volt($view, $di); // pass $di instead of $this

                    return $volt;
                }
            ]);

            return $view;
        });

       
    }
}
