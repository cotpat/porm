<?php

require_once '../vendor/autoload.php';

use Cotpat\Porm\Connection;
use Cotpat\Porm\TestSQLObject;

$connection = new Connection(
  '127.0.0.1',
  'root',
  'strong_password',
  'db',
  '3307'
);

// $testModel = new TestSQLObject();
// $testModels = $testModel->findAll();

echo 'hello??';
echo var_dump($testModels);

echo file_get_contents("html/main.html");
echo var_dump($testModels);
