<?php declare(strict_types=1);

namespace app\services;

class ConfigService extends AbstractService
{
    /** @var array */
    private $config;

    public function init() : void
    {
        $this->config = array_replace(
            require __DIR__ . '/../../app/configs/services.php',
            require __DIR__ . '/../../app/configs/others.php',
            require __DIR__ . '/../../app/configs/envs/' . $this->services->env->getCurrent() . '.php'
        );
    }

    public function get(string $path) : mixed
    {
        $pathParts = explode('.', $path);
        $config = $this->config;
        foreach ($pathParts as $part) {
            $config = $config[$part] ?? null;
            if(!$config) {
                return false;
            }
        }

        return $config;
    }
}