<?php

namespace System\Controller;

use Exception;
use System\Config\Config;
use System\Database\DatabaseManager;
use System\Database\Mysqli\Database;
use System\Database\Mysqli\ORM;
use System\Libraries\Input;
use System\Loader\Loader;

/**
 * Class Controller
 * @package System\Controller
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (21.02.2021)
 */
class Controller {

    /**
     * @var Loader Loader.
     */
    protected $load;

    /**
     * @var Input Input class.
     */
    protected $input;

    /**
     * @var Config Config.
     */
    protected $config;

    /**
     * @var Database|ORM Database connection.
     */
    protected $db;

    /**
     * Controller constructor.
     * @throws Exception Database connect exception.
     */
    public function __construct()
    {
        $this->load = new Loader();
        $this->input = new Input();
        $this->config = new Config();

        if ($this->config->get('database.use')) {
            $this->db = (new DatabaseManager($this->config->get('database')))->getConnection();
        }

        $this->autoload();
    }

    /**
     * Auto loading for helpers and libraries.
     * @throws Exception
     */
    private function autoload(): void
    {
        $autoload = $this->config->get('autoload');

        foreach ($autoload['helpers'] as $helper) {
            $this->load->helper($helper);
        }

        foreach ($autoload['libraries'] as $library) {
            $this->{strtolower($library)} = $this->load->library($library);
        }
    }

    /**
     * Parse and show JSON data.
     * @param array $data
     */
    private function json(array $data): void
    {
        header('Content-type: application/json');
        echo json_encode($data);
    }
}