<?php

namespace app\services;

class ConfigService
{
    private array $config;

    public function __construct()
    {
        $this->config = array_replace(
            require __DIR__ . '/../../app/configs/services.php',
            require __DIR__ . '/../../app/configs/others.php'
        );
    }

    public function get(string $path): mixed
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