<?php

namespace App\Frontend;

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Autoload\Loader;

class Module
{
    public function registerAutoloaders(DiInterface $di = null): void
    {
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

    }
}
