<?php declare(strict_types=1);

namespace app\services;

class RatesDbService extends AbstractService
{
    /** @var array */
    private $db;

    public function init(): void
    {
        $dbFile = $this->services->config->get('services.rates_db.file');
        $this->db = file_exists($dbFile)
            ? json_decode(file_get_contents($dbFile), true, 512, JSON_THROW_ON_ERROR)
            : [];
    }

    /**
     * todo: get, set, save
     */
}