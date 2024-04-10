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

        if (!$this->connect()) {
            echo 'Connection error! Check your credentials, hosts, ports.';
        }
    }

    /**
     * Opens a connection.
     * Called in the constructor.
     *
     * @return bool
     */
    private function connect()
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
     * Assemble and execute a CREATE query
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
        $values
    ) {
        $updateString = ''; // = $this->generateUpdateString($columns);

        $query = "UPDATE $table SET $updateString";
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
        $columns
    ) {
        $query = "SELECT $columns FROM $table";

        $result = $this->mysqli->query($query);
        $response = [];

        if ($result) {
            // TODO
        }

        return $response;
    }
}
