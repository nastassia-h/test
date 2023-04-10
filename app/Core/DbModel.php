<?php

declare(strict_types=1);

namespace App\Core;

use stdClass;
use mysqli_stmt;
use mysqli_result;

/**
 * Class DbModel
 *
 * @package App\Core
 */
abstract class DbModel extends Model
{
   /**
    * @var Database
    */
   public Database $db;

   /**
    * @param Database $db
    * @return void
    */
   public function setDatabase(Database $db): void
   {
      $this->db = $db;
   }

   /**
    * @return string
    */
   abstract protected function tableName(): string;

   /**
    * @return array
    */
   abstract protected function attributes(): array;

   /**
    * @return string
    */
   abstract public function primaryKey(): string;

   /**
    * @return int
    */
   public function save(): int
   {
      $tableName = $this->tableName();
      $attributes = $this->attributes();
      $params = array_map(fn ($attr) => '?', $attributes);
      $values = array_map(fn ($attr) =>  $this->{$attr}, $attributes);
      $type = '';
      $statement = $this->prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ') VALUES(' . implode(',', $params) . ')');
      foreach ($attributes as $attribute) {
         $type .= $this->getType($this->{$attribute});
      }
      $statement->bind_param($type, ...$values);

      $statement->execute();

      return $statement->affected_rows;
   }

   /**
    * @param $where
    * @param $attributes
    * @return int
    */
   public function update($attributes, $where): int
   {
      $tableName = $this->tableName();
      $attrs = array_keys($attributes);
      $params = array_keys($where);
      $sql = implode('AND', array_map(fn ($attr) => "$attr = ?", $params));
      $values = array_values($attributes);
      $type = '';
      $statement = $this->prepare("UPDATE $tableName SET " . implode(' = ?,', $attrs) . " = ?  WHERE $sql");
      $values = array_merge($values, array_values($where));
      foreach ($values as $value) {
         $type .= $this->getType($value);
      }
      $statement->bind_param($type, ...$values);
      $statement->execute();

      return $statement->affected_rows;
   }

   /**
    * @param $where
    * @return DbModel|null
    */
   public function findOne($where): DbModel|null
   {
      $tableName = $this->tableName();
      $attributes = array_keys($where);
      $sql = implode('AND', array_map(fn ($attr) => "$attr = ?", $attributes));
      $statement = $this->prepare("SELECT * FROM $tableName WHERE $sql");
      $type = '';
      foreach ($where as $value) {
         $type .= $this->getType($value);
      }
      $statement->bind_param($type, ...array_values($where));
      $statement->execute();
      $result = $statement->get_result();
      return $result->fetch_object(static::class);
   }

   /**
    * @param string $column
    * @param string $order
    * @return array
    */
   public function getAll(string $column = '', string $order = ''): array
   {
      $tableName = $this->tableName();
      if ($column) {
         $statement = $this->query("SELECT * FROM $tableName ORDER BY $column $order");
      } else {
         $statement = $this->query("SELECT * FROM $tableName");
      }
      return $statement->fetch_all(MYSQLI_ASSOC);
   }

   /**
    * @param $where
    * @return bool
    */
   public function delete($where): bool
   {
      $tableName = $this->tableName();
      $attributes = array_keys($where);
      $sql = implode('AND', array_map(fn ($attr) => "$attr = ?", $attributes));
      $statement = $this->prepare("DELETE FROM $tableName WHERE $sql");
      $type = '';
      foreach ($where as $value) {
         $type .= $this->getType($value);
      }
      $statement->bind_param($type, ...array_values($where));
      $statement->execute();
      return (bool) $statement->affected_rows;
   }

   /**
    * @param string $sql
    * @return mysqli_stmt
    */
   protected function prepare(string $sql): mysqli_stmt
   {
      return $this->db->connection->prepare($sql);
   }

   /**
    * @param string $sql
    * @return mysqli_result
    */
   protected function query(string $sql): mysqli_result
   {
      return $this->db->connection->query($sql);
   }
}
