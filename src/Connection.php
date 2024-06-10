<?php

namespace Cotpat\Porm;

use mysqli;

class Connection {

    /**
     * Data required to connect to MySQL server
     */
    private $host = '';
    private $username = '';
    private $password = '';
    private $dbName = '';
    private $port = '';
    private $socket = '';

    private $mysqli;

    /**
     * Constructor for DB connection
     * Automatically attemps to open connection
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $dbName
     * @param string $port
     * @param string $socket
     * 
     * @return void
     */
    public function __construct(
        $host,
        $username,
        $password,
        $dbName,
        $port,
    ) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->port = $port;

        $this->connect();
        $GLOBALS['mysqli'] = $this->mysqli; 
    }

    /**
     * Opens a connection.
     * Called in the constructor.
     *
     * @return bool
     */
    public function connect()
    {
        $this->mysqli = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->dbName,
            $this->port,
        );

        if ($this->mysqli->connect_error) {
            return false;
        }

        return true;
    }

    /**
     * Closes the connection
     *
     * @return void
     */
    public function disconnect()
    {
        if (isset($this->mysqli)) {
            $this->mysqli->close();
        }
    }

    /**
     * Assemble and execute an INSERT query
     *
     * @param string $table
     * @param array $columns
     * @param array $values
     * @return void
     */
    public function insert(
        $table,
        $columns,
        $values
    ) {
        $query = "INSERT INTO $table $columns VALUES $values";
        return $this->mysqli->query($query);
    }

    /**
     * Assemble and execute an UPDATE query
     * TODO: replace placeholder code
     *
     * @param string $table
     * @param array $columns
     * @param array $values
     * @return mixed
     */
    public function update(
        $table,
        $columns,
        $values,
        $conditions
    ) {
        $updateString  = $this->assembleUpdateString($columns, $values);
        $whereString = $this->assembleWhereString($conditions);

        $query = "UPDATE $table SET $updateString WHERE $whereString";
        $result = $this->mysqli->query($query);

        return $result;
    }

    /**
     * Assemble and execute a SELECT query
     * TODO: replace placeholder code
     *
     * @param string $table
     * @param array $columns
     * @return mixed
     */
    public function select(
        $table,
        $columns,
        $conditions,
        $limit = null,
        $offset = null
    ) {
        $query = "SELECT $columns FROM $table";

        if (!empty($conditions)) {
            $whereString = $this->assembleWhereString($conditions);
            $query .= "WHERE $whereString";
        }

        if (isset($limit) && isset($offset)) {
            $query .= "LIMIT $limit OFFSET $offset";
        }

        $result = $this->mysqli->query($query);
        $response = [];

        if ($result) {
            $response['fields'] = $this->fetchFields($result);
            $response['values'] = mysqli_fetch_all($result);
        }

        return $response;
    }

    public function delete($name, $conditions)
    {
        $whereString = $this->assembleWhereString($conditions);
        $query = "DELETE FROM $name WHERE $whereString";

        return $query;
    }

    /**
     * Assembles the argument string for UPDATE
     *
     * @param array $keys
     * @param array $values
     * @return string
     */
    public function assembleUpdateString($keys, $values)
    {
        $count = count($keys);
        $assembledString = '';

        for ($i = 0; $i < $count; $i++) {
            $assembledString .= $keys[$i] . '=' . $values[$i] . ',';
        }

        $assembledString .= $keys[$count - 1] . '=' . $values [$count -1];
        return $assembledString;
    }

    /**
     * Assembles the WHERE argument string
     *
     * @param array $values
     * @return void
     */
    public function assembleWhereString($values)
    {
        $assembledString = '';

        foreach ($values as $key => $value) {
            $assembledString .= $key . $value[0] . $value[1] . " " . $value[2];
        }

        return $assembledString;
    }

    public function fetchFields($result)
    {
        if ($result) {
            $fieldsData = $result->fetch_fields();
            $fields = [];

            foreach ($fieldsData as $fieldData) {
                $fields[] = $fieldData->name;
            }

            return $fields;
        }

        return [];
    }
}
