<?php

declare(strict_types=1);

namespace App\Core;

use mysqli;

/**
 * Class Database
 *
 * @package App\Core
 */
class Database
{
   /**
    * @var mysqli
    */
   public mysqli $connection;

   public function __construct()
   {
      $this->connection = new mysqli('localhost', 'root', '', 'testtask', 3306);
      if ($this->connection->connect_error) {
         die('Connection failed: ' . $this->connection->connect_error);
      }
   }
}
