<?php

namespace app\services;

use League\Plates\Engine;
use League\Plates\Extension\URI;

class ViewRendererService
{
    private ConfigService $config;

    private Engine $renderer;

    public function __construct(ConfigService $config)
    {
        $this->config = $config;

        $this->renderer = new Engine($this->config->get('services.view_renderer.path'),
            $this->config->get('services.view_renderer.extension'));
        //$this->renderer->loadExtension(new URI($_SERVER['PATH_INFO'] ?? null));
    }

    public function render(string $viewAlias, array $vars = []): string
    {
        $view = $this->renderer->make($viewAlias);
        if(!$view->exists()) {
            throw new \RuntimeException('View not found, alias: ' . $viewAlias);
        }

        return $view->render($vars);
    }
}