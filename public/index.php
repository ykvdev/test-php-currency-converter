<?php declare(strict_types=1);

use app\controllers\AbstractController;
use app\controllers\CommonController;
use FastRoute\Dispatcher;
use \app\services\ConfigService;
use \app\services\ConsoleIoService;
use \app\services\FastRouteService;
use \app\services\GuzzleService;
use \app\services\RatesDbService;
use \app\services\EnvService;
use \app\services\ViewRendererService;
use \app\services\WhoopsService;

new class
{
    /** @var \DI\Container */
    private $di;

    /** @var EnvService */
    private $env;

    /** @var FastRouteService */
    private $fastRoute;

    public function __construct()
    {
        $this->outputAssetIfNeed();

        session_start();

        require __DIR__ . '/../vendor/autoload.php';

        $this->di = new DI\Container();
        $this->di->make(WhoopsService::class);
        $this->env = $this->di->get(EnvService::class);
        $this->fastRoute = $this->di->get(FastRouteService::class);

// for prod
//        $builder = new \DI\ContainerBuilder();
//        $builder->enableCompilation(__DIR__ . '/tmp');
//        $builder->writeProxiesToFile(true, __DIR__ . '/tmp/proxies');
//        $container = $builder->build();

        try {
            $actionData = $this->getActionData();
//            $this->invokeAction($actionData['controller'], $actionData['action'], $actionData['params']);
            $this->di->call([$actionData['controller'], $actionData['action'] . 'Action'],
                ['routeParams' => $actionData['params']]);
        } catch (\Throwable $e) {
            if($this->env->isProd()) {
//                $this->invokeAction(CommonController::class, 'error500');
                $this->di->call([CommonController::class, 'error500']);
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
            if(strstr($filePath, '.css')) {
                $type = 'text/css';
            } elseif(strstr($filePath, '.js')) {
                $type = 'text/javascript';
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

    private function getActionData(): array
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

        return compact('controller', 'action', 'params');
    }

//    private function invokeAction(string $controllerClassName, string $actionAlias, array $routeParams = []) : void
//    {
        /** @var AbstractController $controller */
//        $controller = new $controllerClassName($this->services, $routeParams);
//        $controller->{$actionAlias . 'Action'}();

//        $this->di->call([$controllerClassName, $actionAlias . 'Action'], compact('routeParams'));
//    }
};