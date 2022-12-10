<?php

namespace app;

use app\controllers\CommonController;
use DI\Container;
use FastRoute\Dispatcher;
use app\services\FastRouteService;
use app\services\WhoopsService;

class App
{
    private Container $di;

    private FastRouteService $fastRoute;

    public function __construct()
    {
        session_start();
        $this->di = new Container();
        $this->di->make(WhoopsService::class);
        $this->fastRoute = $this->di->get(FastRouteService::class);
    }

    public function runAction(): void
    {
        $routeData = $this->fastRoute->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        switch ($routeData['result']) {
            case Dispatcher::NOT_FOUND:
                $controller = CommonController::class;
                $action = 'error404';
                $params = [];
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $controller = CommonController::class;
                $action = 'error405';
                $params = [];
                break;

            case Dispatcher::FOUND:
                [$controller, $action] = $routeData['handler'];
                $params = $routeData['params'];
                break;
        }

        $this->di->call([$controller, $action . 'Action'], ['routeParams' => $params]);
    }
};