<?php

require_once 'vendor/autoload.php';
use Cotpat\Porm\TestSQLObject;

$testModel = new TestSQLObject();
$testModels = $testModel->findAll();

echo var_dump($testModels);

echo file_get_contents("html/main.html");
