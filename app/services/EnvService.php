<?php declare(strict_types=1);

namespace app\services;

class EnvService
{
    private const DEV = 'dev';
    private const PROD = 'prod';

    /** @var string */
    private $current;

    public function __construct()
    {
        $this->current = getenv('ENV_CURRENT');
        $this->current = in_array($this->current, [self::DEV, self::PROD]) ? $this->current : self::DEV;
    }

    public function getCurrent() : string
    {
        return $this->current;
    }

    public function isProd() : bool
    {
        return $this->current == self::PROD;
    }
}