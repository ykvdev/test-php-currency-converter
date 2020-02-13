<?php declare(strict_types=1);

namespace app\services;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsService extends AbstractService
{
    public function init(): void
    {
        if(!$this->services->env->isProd()) {
            $handler = new PrettyPageHandler;
            $handler->setEditor($this->services->config->get('services.whoops.editor'));
            (new Run())->prependHandler($handler)->register();
        }
    }
}