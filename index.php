<?php

require_once 'vendor/autoload.php';
use Cotpat\Porm\Connection;
use mysqli;

$connection = new Connection(
  "127.0.0.1",
  "root",
  "root",
  "test",
  "3306"
);

echo file_get_contents("html/main.html");
