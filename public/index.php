<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Autoload\Loader;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;


class App
{
    protected FactoryDefault $di;
    protected Application $application;

    public function __construct()
    {
        $this->di = new FactoryDefault();
        $this->registerRouter();
        $this->registerModules();
        $this->registerServices();
        $this->application = new Application($this->di);
    }

    protected function registerRouter(): void
    {
        $this->di->setShared('router', function () {
            $router = new Router(false);

            $router->add('/', [
                'module'     => 'frontend',
                'controller' => 'index',
                'action'     => 'index',
            ]);

            $router->add('/admin', [
                'module'     => 'backend',
                'controller' => 'index',
                'action'     => 'index',
            ])->setName('posts');

            $router->add('/admin/post/create', [
                'module'     => 'backend',
                'controller' => 'index',
                'action'     => 'create',
            ])->setName('post-create');

            $router->add('/admin/post/update/{id}', [
                'module'     => 'backend',
                'controller' => 'index',
                'action'     => 'update',
            ])->setName('post-update');

            $router->add('/admin/post/delete/{id}', [
                'module'     => 'backend',
                'controller' => 'index',
                'action'     => 'delete',
            ])->setName('post-delete');


            // 404 handler
            $router->notFound([
                'module'     => 'frontend',
                'controller' => 'error',
                'action'     => 'notFound',
            ]);

            return $router;
        });
    }

    protected function registerModules(): void
    {
        $di = $this->di;

        $this->di->setShared('application', function () use ($di) {
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

            return $app;
        });
    }

    public function registerServices(): void
    {
        $di = $this->di;

        $di->set('session', function () {
            $session = new Manager();
            $files = new Stream([
                'savePath' => '/tmp',
            ]);
            $session->setAdapter($files);
            $session->start();
            return $session;
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


    public function run(): void
    {
        try {
            $app = $this->di->get('application');
            $response = $app->handle($_SERVER["REQUEST_URI"]);
            $response->send();
        } catch (\Throwable $e) {
            echo 'Exception: ', $e->getMessage();
        }
    }
}

// Bootstrap the app
$bootstrap = new App();
$bootstrap->run();
