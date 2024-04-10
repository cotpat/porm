<?php

namespace Cotpat\Porm;

class TestSQLObject extends SQLObject
{
  private $tableName = 'testObj';

  public function __construct()
  {
    parent::__construct();
    parent::setTableName($this->tableName);
  }
}