<?php declare(strict_types=1);

namespace app\services;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\cachedDispatcher;

class FastRouteService extends AbstractService
{
    /** @var Dispatcher */
    private $dispatcher;

    public function init(): void
    {
        $this->dispatcher = cachedDispatcher(function(RouteCollector $r) {
            foreach ($this->services->config->get('services.fast_route.routes') as $routeParts) {
                [$method, $route, $controller, $action] = $routeParts;
                $r->addRoute($method, $route, [$controller, $action]);
            }
        }, [
            'cacheFile' => $this->services->config->get('services.fast_route.cache_file'),
            'cacheDisabled' => !$this->services->env->isProd(),
        ]);
    }

    public function dispatch(string $requestMethod, string $requestUri): array
    {
        $routeInfo = $this->dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $this->prepareRequestUri($requestUri));

        return [
            'result' => $routeInfo[0],
            'handler' => $routeInfo[1] ?? null,
            'params' => $routeInfo[2] ?? [],
        ];
    }

    /**
     * Strip query string (?foo=bar) and decode URI
     *
     * @param string $requestUri
     *
     * @return string
     */
    private function prepareRequestUri(string $requestUri): string
    {
        if (false !== $pos = strpos($requestUri, '?')) {
            $requestUri = substr($requestUri, 0, $pos);
        }
        $requestUri = rawurldecode($requestUri);

        return $requestUri;
    }
}