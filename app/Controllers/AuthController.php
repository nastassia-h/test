<?php

namespace App\Controllers;

use App\Services\Database;

class AuthController
{

   public static function register($data)
   {
      $validator = (new AuthValidator)->userValidation($data);

      if (!$validator['status']) {
         http_response_code(500);
      } else {
         http_response_code(201);
      }
      echo json_encode($validator);
   }
}
