<?php declare(strict_types=1);

namespace app\services;

abstract class AbstractService
{
    /** @var ServicesContainer */
    protected $services;

    public function __construct(ServicesContainer $services)
    {
        $this->services = $services;

        $this->init();
    }

    abstract public function init() : void;
}