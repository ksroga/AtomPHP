<?php

namespace System\Loader;

use System\View\View;

/**
 * Class Loader
 * @package System\Loader
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (21.02.2021)
 */
class Loader
{
    /**
     * @var View View manager.
     */
    private $viewManager;

    /**
     * @var string Helpers path.
     */
    private $helpersPath = 'application/helpers/';

    /**
     * @var string System libraries path.
     */
    private $systemLibrariesPath = 'system/libraries/';

    /**
     * @var string Libraries path.
     */
    private $librariesPath = 'application/libraries/';

    /**
     * Loader constructor.
     */
    public function __construct()
    {
        $this->viewManager = new View();
    }

    /**
     * Template loader.
     * @param string $template Template name to load.
     * @param array $passedParameters Parameters to pass to view.
     * @throws \Exception Template does not exist exception.
     */
    public function template(string $template, array $passedParameters = []): void
    {
        $this->viewManager->showTemplate($template, $passedParameters);
    }

    /**
     * Helper loader.
     * @param string $helper Helper name to load.
     * @throws \Exception Helper does not exist exception.
     */
    public function helper(string $helper): void
    {
        $helperFilename = ucfirst(strtolower($helper)) . 'Helper.php';
        if (!file_exists($this->helpersPath . $helperFilename)) {
            throw new \Exception("Helper $helper ($helperFilename) not found.");
        }

        require_once $this->helpersPath . $helperFilename;
    }

    /**
     * Load library.
     * @param string $library
     * @param array|null $constructorArguments
     * @return mixed Loaded library.
     * @throws \Exception Library not found.
     */
    public function library(string $library, ?array $constructorArguments = [])
    {
        $systemLibrary = file_exists($this->systemLibrariesPath . $library . '.php');

        if ($systemLibrary) {
            return $this->loadClass($this->systemLibrariesPath . $library . '.php', $library);
        }

        $libraryExists = file_exists($this->librariesPath . $library . '.php');
        if (!$libraryExists) {
            throw new \Exception("Cannot load library $library: file not found.");
        }

        return $this->loadClass($this->librariesPath . $library . '.php', $library);
    }

    /**
     * Load class.
     * @param string $path File path.
     * @param string $className Class name.
     * @return mixed Loaded class.
     */
    private function loadClass(string $path, string $className)
    {
        require_once $path;
        $class = "System\Libraries\\$className";
        return new $class();
    }
}