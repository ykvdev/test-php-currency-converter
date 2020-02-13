<?php declare(strict_types=1);

use app\controllers\AbstractController;
use app\controllers\CommonController;
use FastRoute\Dispatcher;
use \app\services\ServicesContainer;

new class
{
    /** @var ServicesContainer */
    private $services;

    public function __construct()
    {
        $this->outputAssetIfNeed();

        session_start();
        require __DIR__ . '/../vendor/autoload.php';
        $this->services = new ServicesContainer();
        $this->services->env->init();
        $this->services->config->init();
        $this->services->whoops->init();

        try {
            $actionData = $this->getActionData();
            $this->invokeAction($actionData['controller'], $actionData['action'], $actionData['params']);
        } catch (\Throwable $e) {
            if($this->services->env->isProd()) {
                $this->invokeAction(CommonController::class, 'error500');
            } else {
                throw $e;
            }
        }
    }

    /**
     * ONLY FOR PHP BUILT-IN SERVER
     */
    private function outputAssetIfNeed(): void
    {
        if(in_array($_SERVER['REQUEST_URI'], [
            '/assets/css/common.css',
            '/assets/js/page-index.js',
            '/favicon.ico'
        ], true)) {
            $filePath = __DIR__ . $_SERVER['REQUEST_URI'];
            //    $type = strstr($filePath, '.css') ? 'text/css' : 'image/x-icon';
            //    header('Content-Type: ' . $type);
            echo file_get_contents($filePath);
            exit;
        }
    }

    private function getActionData(): array
    {
        $routeData = $this->services->fastRoute->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
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

        return compact('controller', 'action', 'params');
    }

    private function invokeAction(string $controllerClassName, string $actionAlias, array $routeParams = []) : void
    {
        /** @var AbstractController $controller */
        $controller = new $controllerClassName($this->services, $routeParams);
        $controller->{$actionAlias . 'Action'}();
    }
};