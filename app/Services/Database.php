<?php

namespace App\Services;

class Database
{
   private $host = "127.0.0.1";
   private $username = "root";
   private $password = "";
   private $port = 3306;

   protected $db = "testtask";

   function __construct()
   {
      if (!\R::testConnection()) {
         \R::setup('mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db . '', $this->username, $this->password);
      }
   }

   public function insert(string $table_name, array $columns)
   {
      $newObject = \R::dispense($table_name);
      foreach ($columns as $columnName => $columnValue) {
         $newObject->$columnName = $columnValue;
      }
      $newObjectId = \R::store($newObject);
      return $newObjectId;
   }

   public function find(string $table_name, string $properties = "", array $values = [])
   {
      if (count($values) && !empty($properties)) {
         return \R::find($table_name, $properties, $values);
      } elseif (!count($values) && !empty($properties))
         return \R::find($table_name, $properties);
      else
         return \R::find($table_name);
   }

   public function select(string $table_name, string $properties = "", array $values = [])
   {
      if (count($values) && !empty($properties)) {
         return \R::getAll("SELECT * FROM $table_name WHERE $properties", $values);
      } elseif (!count($values) && !empty($properties))
         return \R::getAll("SELECT * FROM $table_name WHERE $properties");
      else
         return \R::getAll("SELECT * FROM $table_name");
   }

   public function remove(string $table_name, string $properties = "", array $values = [])
   {
      $objects = $this->find($table_name, $properties, $values);
      if ($objects) {
         \R::trashAll($objects);
         return true;
      } else return false;
   }
}
