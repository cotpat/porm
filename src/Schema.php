<?php

namespace Cotpat\Porm;

use Cotpat\Porm\SQLObject;

/**
 * represents the schema of a model
 */
class Schema
{
  /**
   * Fields in Schema
   *
   * @var array
   */
  private $fields = [];

  /**
   * Construct Schema with array of Fields passed to input
   *
   * @param Field ...$args
   */
  public function __construct(Field ...$fields)
  {
    foreach ($fields as $field) {
      $this->fields[] = $field;
    }

    //throw new \Exception(var_dump($fields), 1);
    
  }

  public function addField(Field $field)
  {
    $this->fields[] = $field;
  }

  public function getFields()
  {
    return $this->fields;
  }
}