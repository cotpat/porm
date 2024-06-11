<?php

require_once '../vendor/autoload.php';

use Cotpat\Porm\Connection;
use Cotpat\Porm\Field;
use Cotpat\Porm\Model;
use Cotpat\Porm\Schema;
use Cotpat\Porm\TestSQLObject;

$connection = new Connection(
  '127.0.0.1',
  'root',
  'strong_password',
  'porm-db',
  '3307'
);

$testModelSchema = new Schema(
  new Field('Name', Field::TYPE_STRING_VARCHAR),
  new Field('Age', Field::TYPE_INT_INT)
);

$testModel = new Model('Person', $testModelSchema);