<?php

namespace App\Backend;

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Autoload\Loader;

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
    }
}
