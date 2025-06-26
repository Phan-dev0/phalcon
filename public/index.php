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
use Phalcon\Mvc\Router\Annotations;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Security;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model\Manager as ModelManager;

use App\Services\DateFormatter;
use App\Backend\Models\Post;

class App
{
    protected FactoryDefault $di;
    protected Application $application;

    public function __construct()
    {
        $this->di = new FactoryDefault();
        $this->registerAutoloader();
        $this->registerServices();
        $this->registerRouter();
        $this->application = new Application($this->di);
        $this->registerModules();
    }

    protected function registerAutoloader()
    {
        $loader = new Loader();

        $loader->setNamespaces([
            'App\Frontend' => __DIR__ . '/../app/frontend/',
            'App\Backend'  => __DIR__ . '/../app/backend/',
            'App\Services'  => __DIR__ . '/../app/services/',
        ]);

        $loader->register();
    }

    protected function registerRouter(): void
    {
        $this->di->setShared('router', function () {
            $router = new Annotations(false);

            $router->setDefaultModule('frontend');

            $router->addModuleResource(
                'frontend',
                'App\Frontend\Controllers\Index',
                '/'
            );

            // Backend annotation
            $router->addModuleResource(
                'backend',
                'App\Backend\Controllers\AdminPost',
                '/admin'
            );

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
        $this->application->registerModules([
            'frontend' => [
                'className' => 'App\Frontend\Module',
                'path'      => '../app/frontend/Module.php',
            ],
            'backend' => [
                'className' => 'App\Backend\Module',
                'path'      => '../app/backend/Module.php',
            ]
        ]);
    }

    public function registerServices(): void
    {
        $di = $this->di;

        // custom service
        $di->setShared("dateFormatter", function () {
            return new DateFormatter;
        });
        // =================

        $di->setShared('eventsManager', function () {
            $eventsManager = new EventsManager();

            // Attach model events
            $eventsManager->attach('model', function ($event, $model) {
                if ($model instanceof Post) {
                    if ($event->getType() === 'afterCreate') {
                        error_log("[Post Created] ID: {$model->getId()}, Title: {$model->getTitle()}");
                    }

                    if ($event->getType() === 'beforeSave') {
                        error_log("[Saving Post] Title: " . $model->getTitle());
                    }

                    if ($event->getType() === 'afterDelete') {
                        error_log("[Post Deleted] ID: {$model->getId()}, Title: {$model->getTitle()}");
                    }
                }
            });

            return $eventsManager;
        });

        // This makes all your models respond to the global model events you attached.
        $di->setShared('modelsManager', function () use ($di) {
            $modelsManager = new ModelManager();
            $modelsManager->setEventsManager($di->get('eventsManager'));
            return $modelsManager;
        });

        $di->setShared(
            'transactions',
            function () {
                return new TransactionManager();
            }
        );

        $di->setShared('timezone', function () {
            return 'Asia/Ho_Chi_Minh';
        });

        $di->setShared('view', function () use ($di) {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/../app/views/');

            $view->registerEngines([
                '.volt' => function ($view) use ($di) {
                    $volt = new Volt($view, $di);
                    $volt->setOptions([
                        'always' => true,
                    ]);

                    $compiler = $volt->getCompiler();

                    $compiler->addFunction('formatDate', function ($resolvedArgs) {
                        return "\$this->di->get('dateFormatter')->format($resolvedArgs)";
                    });

                    return $volt;
                }
            ]);

            return $view;
        });

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
            $response = $this->application->handle($_SERVER["REQUEST_URI"]);
            $response->send();
        } catch (\Throwable $e) {
            echo 'Exception: ', $e->getMessage();
        }
    }
}

// Bootstrap the app
$bootstrap = new App();
$bootstrap->run();
