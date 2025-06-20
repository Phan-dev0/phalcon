<?php

namespace App\Backend;

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
        error_log("Backend");
        $loader = new Loader();

        $loader->setNamespaces([
            'App\Backend\Controllers' => __DIR__ . '/controllers/',
            'App\Backend\Models'      => __DIR__ . '/models/',
        ])->setDirectories([
            __DIR__ . '/controllers/',
            __DIR__ . '/models/',
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
                    $volt = new Volt($view, $di); // pass $di instead of $this

                    return $volt;
                }
            ]);

            return $view;
        });


        $di->set('db', function () {
            return new Mysql(
                [
                    "host"     => "db",
                    "username" => "myuser",
                    "password" => "mypassword",
                    "dbname"   => "mydatabase",
                ]
            );
        });
    }
}
