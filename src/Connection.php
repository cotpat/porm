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
        $socket,
    ) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->port = $port;
        $this->socket = $socket;

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
            $this->socket
        );

        if ($this->mysqli->connect_error) {
            return false;
        }

        return true;
    }

    public function disconnect()
    {
        if (isset($this->mysqli)) {
            $this->mysqli->close();
        }
    }
}
