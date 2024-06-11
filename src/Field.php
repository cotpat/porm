<?php

namespace Cotpat\Porm;

use ReflectionClass;

/**
 * Represents a field in a schema
 */
class Field
{
  const TYPE_INT_TINY   = 'TINYINT';
  const TYPE_INT_SMALL  = 'SMALLINT';
  const TYPE_INT_MEDIUM = 'MEDIUMINT';
  const TYPE_INT_INT    = 'INT';
  const TYPE_INT_BIGINT = 'BIGINT';

  const TYPE_STRING_CHAR    = 'CHAR';
  const TYPE_STRING_VARCHAR = 'VARCHAR(255)';
  const TYPE_STRING_TEXT    = 'TEXT';

  private $name;
  private $type;

  public function __construct(String $name, String $type)
  {
    $this->setField($name, $type);
  }

  /**
   * Set combination of name and type
   *
   * @param String $name
   * @param String $type
   * @return void
   */
  public function setField(String $name, String $type): void
  {
    if (!$this->validateType($type)) {
      throw new \Exception("Invalid type: $type", 1);
    }

    $this->name = $name;
    $this->type = $type;
  }

  private function getTypeConstants(): array
  {
    $reflectionClass = new ReflectionClass($this);
    return $reflectionClass->getConstants();
  }

  private function validateType(string $type): bool
  {
    $types = array_values($this->getTypeConstants());

    if (in_array($type, $types)) {
      return true;
    }

    return false;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getType(): string
  {
    return $this->type;
  }
}