<?php

namespace Cotpat\Porm;

/**
 * Represents a model with a Schema
 */
class Model
{
  /**
   * the schema
   *
   * @var Schema
   */
  private Schema $schema;

  private string $tablename;

  public function __construct(string $tablename, Schema $schema)
  {
    $this->schema = $schema;
    $this->tablename = $tablename;

    $this->createTable($this->generateCreateTableStatement());
  }

  private function createTable(string $statement): void
  {
    $GLOBALS['mysqli']->query($statement);
  }

  private function generateCreateTableStatement(): string
  {
    $fields = $this->schema->getFields();

    $statement =
      "CREATE TABLE IF NOT EXISTS `{$this->tablename}` (
      ID INT PRIMARY KEY AUTO_INCREMENT,";

    foreach ($fields as $field) {
      $statement .= " `{$field->getName()}` {$field->getType()},";
    }
    $statement = rtrim($statement, ',');
    $statement .= ');';

    //throw new \Exception($statement, 1);
    
    return $statement;
  }
}