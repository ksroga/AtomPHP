<?php

namespace System\Router;

use System\Controller\Controller;
use System\View\View;

/**
 * Class Router
 * @package system\router
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (21.02.2021)
 */
class Router {

    /**
     * @var string|string[] Base url.
     */
    private $baseUrl;

    /**
     * @var string Current url.
     */
    private $currentUrl;

    /**
     * @var mixed Current path.
     */
    private $currentPath;

    /**
     * @var false|string[] Current routing.
     */
    private $routing;

    /**
     * @var string Controller path.
     */
    private $controllerDirectory = 'application/controllers/';

    /**
     * Router constructor.
     * @param string $baseUrl Base url from config.
     */
    public function __construct(string $baseUrl) {
        $this->baseUrl = str_replace('http://', '', $baseUrl);
        $this->currentUrl = $_SERVER['HTTP_HOST'] . explode('?', $_SERVER['REQUEST_URI'])[0];
        $this->currentPath = $_SERVER['REQUEST_URI'];
        $this->routing = array_filter(explode('/', str_replace($this->baseUrl, '', $this->currentUrl)));
    }

    /**
     * Get controller by routing.
     * @return mixed Controller.
     * @throws \Exception Controller does not exist.
     */
    public function getController()
    {
        $controller = reset($this->routing) ?: 'index';
        $controllerClassName = ucfirst(strtolower($controller)) . 'Controller';
        $controllerName = $controllerClassName . '.php';
        $controllerPath = $this->controllerDirectory . $controllerName;

        if (!file_exists($controllerPath)) {
            $message = "404 - Page not found :(";
            $viewManager = new View();
            $viewManager->showTemplate('error/index', ['message' => $message]);
        }

        require_once $controllerPath;

        return new $controllerClassName();
    }

    /**
     * Get controller method by route.
     * @param Controller $controller Current controller
     * @return mixed|string Controller method name.
     * @throws \Exception Method does not exists.
     */
    public function getControllerMethod(Controller $controller)
    {
        reset($this->routing);
        $method = next($this->routing);
        $methodExists = method_exists($controller, $method);
        $defaultMethodExists = method_exists($controller, 'index');
        if (!$methodExists && !$defaultMethodExists) {
            throw new \Exception("Methods $method() and index() not found in " . get_class($controller));
        }
        return $methodExists ? $method : 'index';
    }
}