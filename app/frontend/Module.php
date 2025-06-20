<?php

namespace App\Frontend;

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
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

        $di->setShared('view', function () {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');
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
