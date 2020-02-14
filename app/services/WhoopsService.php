<?php declare(strict_types=1);

namespace app\services;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsService
{
    /** @var EnvService */
    private $env;

    /** @var ConfigService */
    private $config;

    public function __construct(EnvService $env, ConfigService $config)
    {
        $this->env = $env;
        $this->config = $config;

        if(!$this->env->isProd()) {
            $handler = new PrettyPageHandler;
            $handler->setEditor($this->config->get('services.whoops.editor'));
            (new Run())->prependHandler($handler)->register();
        }
    }
}