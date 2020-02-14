<?php declare(strict_types=1);

use app\controllers\AbstractController;
use app\controllers\CommonController;
use FastRoute\Dispatcher;
use \app\services\ConfigService;
use \app\services\ConsoleIoService;
use \app\services\FastRouteService;
use \app\services\GuzzleService;
use \app\services\ViewRendererService;
use \app\services\WhoopsService;

new class
{
    /** @var \DI\Container */
    private $di;

    /** @var FastRouteService */
    private $fastRoute;

    public function __construct()
    {
        $this->outputAssetIfNeed();

        session_start();

        require __DIR__ . '/../vendor/autoload.php';

//        $this->di = new DI\Container();
//        $this->di->make(WhoopsService::class);
//        $this->fastRoute = $this->di->get(FastRouteService::class);

        $builder = new \DI\ContainerBuilder();
//        $builder->enableCompilation(__DIR__ . '/tmp');
//        $builder->writeProxiesToFile(true, __DIR__ . '/tmp/proxies');
        $this->di = $builder->build();
        $this->di->make(WhoopsService::class);
        $this->fastRoute = $this->di->get(FastRouteService::class);

        $this->runAction();
    }

    /**
     * ONLY FOR PHP BUILT-IN SERVER
     */
    private function outputAssetIfNeed(): void
    {
        if(in_array($_SERVER['REQUEST_URI'], [
            '/assets/css/common.css',
            '/assets/css/page-index.css',
            '/assets/js/page-index.js',
            '/rates.json',
            '/favicon.ico'
        ], true)) {
            $filePath = __DIR__ . $_SERVER['REQUEST_URI'];
            if(strstr($filePath, '.css')) {
                $type = 'text/css';
            } elseif(strstr($filePath, '.js')) {
                $type = 'text/javascript';
            } elseif(strstr($filePath, '.json')) {
                $type = 'application/json';
            } elseif(strstr($filePath, '.ico')) {
                $type = 'image/x-icon';
            } else {
                $type = '';
            }
            header('Content-Type: ' . $type);
            echo file_get_contents($filePath);
            exit;
        }
    }

    private function runAction(): void
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

        //            $this->invokeAction($actionData['controller'], $actionData['action'], $actionData['params']);
        $this->di->call([$controller, $action . 'Action'], ['routeParams' => $params]);
    }

//    private function invokeAction(string $controllerClassName, string $actionAlias, array $routeParams = []) : void
//    {
        /** @var AbstractController $controller */
//        $controller = new $controllerClassName($this->services, $routeParams);
//        $controller->{$actionAlias . 'Action'}();

//        $this->di->call([$controllerClassName, $actionAlias . 'Action'], compact('routeParams'));
//    }
};