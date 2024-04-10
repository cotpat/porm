<?php

namespace Cotpat\Porm;

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
}
