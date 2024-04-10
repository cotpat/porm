<?php

namespace Cotpat\Porm;

use Cotpat\Porm\Connection;

/**
 * Represents an object mapping of an SQL table
 */
class SQLObject
{
  private $tableName = '';
  private $connection;

  public function __construct()
  {
    $this->connection = new Connection(
      '127.0.0.1',
      'porm-devel',
      'porm-pw',
      'test',
      '3306'
    );

    if (!$this->connection->connect()) {
      echo "Uh oh -- connection failed";
      return;
    }

    $this->loadClassProperties();
  }

  public function findAll()
  {
    $result = $this->connection->select($this->tableName, '*', []);
    return $this->buildResponseObject($result);
  }

  public function findById($id)
  {
    $result = $this->connection->select($this->tableName, '*', ['id' => ['=', $id, '']]);
    $result = $this->buildResponseObject($result);

    if ($result) {
      return $result[0];
    }

    return (object)[];
  }

  // public function save()
  // {
  //   $fields = $this->connection->fetchFields($this->tableName);

  //   if (isset($this->id)) {
  //     return $this->connection->update($this->tableName, $fields, (array)$this, ['id' => ['=', $this->id, '']]);
  //   }

  //   return $this->connection->insert($this->tableName, $fields, (array)$this);
  // }

  public function loadClassProperties()
  {
    $fields = $this->connection->fetchFields($this->tableName);

    foreach ($fields as $field) {
      $this->$field = null;
    }
  }

  public function buildResponseObject($result)
  {
    $response = [];

    if ($result) {
      $fields = $result['fields'];
      $values = $result['values'];

      $rowCount = count($result['values']);
      $fieldCount = count($result['values'][0]);

      $buildResponse = [];

      for ($i = 0; $i < $rowCount; $i++) {
        for ($j = 0; $j < $fieldCount; $j++) {
          $buildResponse[$fields[$j]] = $values[$i][$j];
        }

        $response[] = $buildResponse;
      }
    }

    return json_decode(json_encode($response));
  }

  public function setTableName($tableName)
  {
    $this->tableName = $tableName;
  }
}