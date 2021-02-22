<?php

namespace System\Database\Mysqli;

/**
 * Class ORM
 * @package System\Database\Mysqli
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (21.02.2021)
 */
class ORM
{
    /**
     * PDO Connection.
     * @var \PDO
     */
    private $connection;

    /**
     * Select parameters.
     * @var string
     */
    private $select;

    /**
     * Table name.
     * @var string
     */
    private $table;

    /**
     * Inserting columns.
     * @var string
     */
    private $insertColumns;

    /**
     * Inserting values.
     * @var string
     */
    private $insertValues;

    /**
     * Update set values.
     * @var string
     */
    private $set;

    /**
     * Set query as delete.
     * @var bool
     */
    private $delete = false;

    /**
     * Where parameters.
     * @var string
     */
    private $where;

    /**
     * Generated query.
     * @var string
     */
    private $query;


    /**
     * ORM constructor.
     * @param Database $connection
     */
    public function __construct(Database $connection)
    {
        $this->connection = $connection->getConnection();
    }

    /**
     * Set parameters to insert.
     * @param array $parameters Insert parameters.
     * @return $this
     */
    public function insert(array $parameters): ORM
    {
        $this->insertColumns = '';
        $this->insertValues = '';
        $i = 0;
        foreach ($parameters as $column => $value) {
            $i++;
            $this->insertColumns .= $column . ($i !== count($parameters) ? ',' : '') . ' ';
            $this->insertValues .= '"' . $value . ($i !== count($parameters) ? ',' : '') . '" ';
        }

        return $this;
    }

    /**
     * Set parameters to select.
     * @param string $columns Select parameters.
     * @return $this
     */
    public function select(string $columns): ORM
    {
        $this->select = $columns;

        return $this;
    }

    /**
     * Set table name.
     * @param string $from
     * @return $this
     */
    public function from(string $from): ORM
    {
        $this->table = $from;

        return $this;
    }

    /**
     * Set table name.
     * @param string $into Table name.
     * @return ORM
     */
    public function into(string $into): ORM
    {
        return $this->from($into);
    }

    /**
     * Set table name.
     * @param string $table
     * @return ORM
     */
    public function update(string $table): ORM
    {
        return $this->from($table);
    }

    /**
     * Update query set parameters.
     * @param array $values Set parameters
     * @return $this
     */
    public function set(array $values): ORM
    {
        $this->set = '';
        $i = 0;
        foreach ($values as $column => $value) {
            $i++;
            $this->set .= $column . ' = "' . $value . '"' . ($i !== count($values) ? ',' : '');
        }

        return $this;
    }

    /**
     * Set query as delete.
     * @return $this
     */
    public function delete(): ORM
    {
        $this->delete = true;
        return $this;
    }

    /**
     * Set where parameters.
     * @param array $where Where parameters.
     * @return $this
     */
    public function where(array $where): ORM
    {
        $this->where = '';
        foreach ($where as $key => $value) {
            $this->where .= $key . ' = "' . $value . '"';
        }

        return $this;
    }


    public function get()
    {
        $this->generateQuery();
        $query = $this->connection->query($this->query);
        $this->clearQuery();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get generated query.
     * @return string|null Generated query or null if error.
     */
    public function getQuery(): ?string
    {
        $this->generateQuery();
        return $this->query;
    }

    /**
     * Generate query.
     */
    private function generateQuery(): void
    {
        if (!empty($this->select)) {
            $this->generateSelectQuery();
            return;
        }

        if (!empty($this->insertColumns)) {
            $this->generateInsertQuery();
            return;
        }

        if (!empty($this->set)) {
            $this->generateUpdateQuery();
            return;
        }

        if ($this->delete) {
            $this->generateDeleteQuery();
            return;
        }
    }

    /**
     * Clear query data.
     */
    public function clearQuery(): void
    {
        $this->select = null;
        $this->table = null;
        $this->insertColumns = null;
        $this->insertValues = null;
        $this->where = null;
        $this->query = null;
        $this->set = null;
        $this->delete = false;
    }

    /**
     * Generate select query.
     */
    private function generateSelectQuery(): void
    {
        $this->query = 'SELECT ' . $this->select . ' ';
        $this->query .= 'FROM ' . $this->table . ' ';

        if (!empty($this->where)) {
            $this->query .= 'WHERE ' . $this->where . ' ';
        }
    }

    /**
     * Generate insert query.
     */
    private function generateInsertQuery(): void
    {
        $this->query = 'INSERT INTO ' . $this->table
            . ' (' . $this->insertColumns . ') VALUES ('
            . $this->insertValues . ')';
    }

    /**
     * Generate update query.
     */
    private function generateUpdateQuery(): void
    {
        $this->query = 'UPDATE ' . $this->table . ' SET ' . $this->set;

        if (!empty($this->where)) {
            $this->query .= ' WHERE ' . $this->where . ' ';
        }
    }

    /**
     * Generate delete query.
     */
    private function generateDeleteQuery(): void
    {
        $this->query = 'DELETE FROM ' . $this->table . ' ';

        if (!empty($this->where)) {
            $this->query .= ' WHERE ' . $this->where . ' ';
        }
    }
}