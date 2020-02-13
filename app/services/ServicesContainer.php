<?php //declare(strict_types=1);
//
//namespace app\services;
//
///**
// * @property-read EnvService $env
// * @property-read ConfigService $config
// * @property-read ConsoleIoService $consoleIo
// * @property-read GuzzleService $guzzle
// * @property-read ViewRendererService $viewRenderer
// * @property-read RatesDbService $ratesDb
// * @property-read WhoopsService $whoops
// * @property-read FastRouteService $fastRoute
// */
//class ServicesContainer
//{
//    /** @var AbstractService[] */
//    private $serviceInstances = [];
//
//    public function __get(string $serviceAlias) : AbstractService
//    {
//        if (!isset($this->serviceInstances[$serviceAlias])) {
//            $serviceClassName = ucfirst($serviceAlias) . 'Service';
//            $this->serviceInstances[$serviceAlias] = new $serviceClassName;
//        }
//
//        return $this->serviceInstances[$serviceAlias];
//    }
//}