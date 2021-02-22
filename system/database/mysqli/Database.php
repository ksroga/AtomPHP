<?php

namespace System\Database\Mysqli;

use System\Database\AbstractDatabase;

/**
 * Class Database
 * @package System\Database\Mysqli
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (21.02.2021)
 */
class Database extends AbstractDatabase
{
    /**
     * Connect to database.
     * @param string $host Database host.
     * @param string $user Database user.
     * @param string $password Database password.
     * @param string $dbName Database name.
     */
    protected function connect(string $host, string $user, string $password, string $dbName): void
    {
        $this->connection = new \PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    }
}