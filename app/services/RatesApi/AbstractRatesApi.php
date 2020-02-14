<?php declare(strict_types=1);

namespace app\services\RatesApi;

use app\services\ConfigService;
use app\services\GuzzleService;

abstract class AbstractRatesApi
{
    /** @var ConfigService */
    protected $config;

    /** @var GuzzleService */
    protected $guzzle;

    public function __construct(GuzzleService $guzzle, ConfigService $config)
    {
        $this->guzzle = $guzzle;
        $this->config = $config;
    }

    abstract public function getLatestRates(string $baseSymbol): array;
}