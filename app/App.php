<?php

namespace app;

use app\controllers\CommonController;
use app\services\ConfigService;
use DI\Container;
use FastRoute\Dispatcher;
use app\services\FastRouteService;
use app\services\WhoopsService;

class App
{
    private string $requestMethod;

    private string $requestUri;

    private Container $di;

    private ConfigService $config;

    private FastRouteService $fastRoute;

    public function __construct(string $requestMethod, string $requestUri)
    {
        $this->requestMethod = $requestMethod;
        $this->requestUri = $requestUri;

        $this->di = new Container();
        $this->di->make(WhoopsService::class);
        $this->config = $this->di->get(ConfigService::class);
        $this->fastRoute = $this->di->get(FastRouteService::class);
    }

    public function run(): void
    {
        $requestFilePath = $this->config->get('public_dir_path') . $this->requestUri;
        if($fileMimeType = $this->getPublicFileMimeType($requestFilePath)) {
            header('Content-Type: ' . $fileMimeType);
            echo file_get_contents($requestFilePath);
        } else {
            $this->runAction();
        }
    }

    /**
     * Returns file MIME-type or false if not available for public
     */
    private function getPublicFileMimeType(string $filePath): string|false
    {
        if(!is_file($filePath) || !is_readable($filePath)) {
            return false;
        }

        $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
        $fileMimeType = $this->config->get('available_public_file_extensions')[$fileExt] ?? null;
        if(!$fileMimeType) {
            return false;
        }

        $publicFileList = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->config->get('public_dir_path'),
            \FilesystemIterator::CURRENT_AS_PATHNAME | \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS)));
        if(!isset($publicFileList[$filePath])) {
            return false;
        }

        return $fileMimeType;
    }

    private function runAction(): void
    {
        $routeData = $this->fastRoute->dispatch($this->requestMethod, $this->requestUri);
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