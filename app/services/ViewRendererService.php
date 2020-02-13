<?php declare(strict_types=1);

namespace app\services;

use League\Plates\Engine;
use League\Plates\Extension\URI;

class ViewRendererService
{
    /** @var ConfigService */
    private $configService;

    /** @var Engine */
    private $renderer;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;

        $config = $this->configService->get('services.view_renderer');
        $this->renderer = new Engine($config['path'], $config['extension']);
        $this->renderer->loadExtension(new URI($_SERVER['PATH_INFO'] ?? null));
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