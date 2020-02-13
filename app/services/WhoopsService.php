<?php declare(strict_types=1);

namespace app\services;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsService
{
    /** @var EnvService */
    private $envService;

    /** @var ConfigService */
    private $configService;

    public function __construct(EnvService $envService, ConfigService $configService)
    {
        $this->envService = $envService;
        $this->configService = $configService;

        if(!$this->envService->isProd()) {
            $handler = new PrettyPageHandler;
            $handler->setEditor($this->configService->get('services.whoops.editor'));
            (new Run())->prependHandler($handler)->register();
        }
    }
}