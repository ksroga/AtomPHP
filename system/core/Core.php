<?php

namespace System\Core;

require_once "system/config/Config.php";
require_once "system/router/Router.php";
require_once "system/loader/Loader.php";
require_once "system/view/View.php";
require_once "system/controller/Controller.php";
require_once "system/libraries/Input.php";
require_once "system/libraries/Client.php";
require_once "system/database/DatabaseManager.php";

use System\Config\Config;
use System\Router\Router;
use System\Controller\Controller;

/**
 * Class Core
 * @package System\Core
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (21.02.2021)
 */
class Core {

    /**
     * @var Config Config.
     */
    private $config;

    /**
     * @var Router Router.
     */
    private $router;

    /**
     * @var Controller Controller.
     */
    private $controller;

    /**
     * @var string Environment.
     */
    private $environment;

    /**
     * Core constructor.
     * Set config, router and controller.
     */
    public function __construct()
    {
        $this->config = new Config();
        $this->environment = $this->config->get('base.environment');

        $this->setDisplayErrorsSettings();

        $this->router = new Router($this->config->get('base.url'));

        $this->controller = $this->router->getController();
        $this
            ->controller
            ->{$this->router->getControllerMethod($this->controller)}();
    }

    /**
     * Set display errors settings.
     */
    private function setDisplayErrorsSettings(): void
    {
        $displayErrors = $this->environment === 'production' ? 0 : 1;
        ini_set('display_errors', $displayErrors);
        ini_set('display_startup_errors', $displayErrors);
        error_reporting($this->config->get('base.error_reporting'));
    }
}