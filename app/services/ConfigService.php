<?php declare(strict_types=1);

namespace app\services;

class ConfigService
{
    /** @var EnvService */
    private $env;

    /** @var array */
    private $config;

    public function __construct(EnvService $env)
    {
        $this->env = $env;

        $this->config = array_replace(
            require __DIR__ . '/../../app/configs/services.php',
            require __DIR__ . '/../../app/configs/others.php',
            require __DIR__ . '/../../app/configs/envs/' . $this->env->getCurrent() . '.php'
        );
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function get(string $path)
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