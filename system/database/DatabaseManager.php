<?php

namespace System\Database;

use System\Database\Mysqli\Database;
use System\Database\Mysqli\ORM;

require_once 'AbstractDatabase.php';

/**
 * Class DatabaseManager
 * @package System\Database
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (21.02.2021)
 */
class DatabaseManager
{

    /**
     * @var array Database config.
     */
    private $config;

    /**
     * @var string|null Database type.
     */
    private $type;

    /**
     * @var Database Database object.
     */
    private $connection;

    /**
     * ORM handler if available.
     * @var ORM|null ORM Object;
     */
    private $orm;

    /**
     * DatabaseManager constructor.
     * @param array $databaseConfig Database config.
     * @throws \Exception Database error exception.
     */
    public function __construct(array $databaseConfig)
    {
        $this->config = $databaseConfig;
        $this->type = $databaseConfig['type'];

        $this->validType();
        $this->loadLibrary();

        $this->connection = new Database(
            $this->config['host'],
            $this->config['user'],
            $this->config['password'],
            $this->config['database_name']
        );

        $this->loadORM();
    }

    /**
     * Get ORM if available or get directly connection.
     * @return Database|ORM Database connection.
     */
    public function getConnection()
    {
        return $this->orm ?? $this->connection;
    }

    /**
     * Check if exist library for provided database type.
     * @throws \Exception Library does not exist exception.
     */
    private function validType(): void
    {
        if (!file_exists("system/database/{$this->type}/Database.php")) {
            throw new \Exception("Library for database type {$this->type} does not exist!");
        }
    }

    /**
     * Load library for database type.
     */
    private function loadLibrary(): void
    {
        require_once "system/database/{$this->type}/Database.php";
    }

    /**
     * Load ORM if available.
     */
    private function loadORM(): void
    {
        $ormPath = "system/database/{$this->type}/ORM.php";
        if (file_exists($ormPath))
        {
            require_once $ormPath;
            $this->orm = new ORM($this->connection);
        }
    }
}