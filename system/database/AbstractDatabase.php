<?php

namespace System\Database;

/**
 * Class AbstractDatabase
 * @package System\Database
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (21.02.2021)
 */
abstract class AbstractDatabase
{
    /**
     * @var mixed Database connection.
     */
    protected $connection;

    /**
     * Connect to database.
     * @param string $host Database host.
     * @param string $user Database user.
     * @param string $password Database password.
     * @param string $dbName Database name.
     */
    abstract protected function connect(
        string $host,
        string $user,
        string $password,
        string $dbName
    ): void;

    /**
     * AbstractDatabase constructor.
     * @param string $host Database host.
     * @param string $user Database user.
     * @param string $password Database password.
     * @param string $dbName Database name.
     */
    public function __construct(string $host, string $user, string $password, string $dbName)
    {
        try {
            $this->connect($host, $user, $password, $dbName);
        } catch (\Exception $exception) {
            exit('Cannot connect to database!');
        }
    }

    /**
     * Get database connection.
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }
}