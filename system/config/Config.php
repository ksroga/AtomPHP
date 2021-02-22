<?php

namespace System\Config;

class Config {

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var string
     */
    private $configsPath = 'application/config/';

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->loadConfigs();
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        $indexes = explode('.', $key);
        $config = $this->config;

        foreach ($indexes as $index) {
            $config = $config[$index] ?? $config;
        }

        return $config;
    }

    private function loadConfigs()
    {
        $configs = scandir($this->configsPath);

        foreach ($configs as $config) {
            if (strpos($config, '.php') === false) {
                continue;
            }

            $this->config = array_merge($this->config, $this->getConfig($config));
        }

    }

    private function getConfig(string $configName): ?array
    {
        if (file_exists($this->configsPath . $configName)) {
            require $this->configsPath . $configName;

            return $config ?? null;
        }
    }
}