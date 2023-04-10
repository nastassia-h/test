<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Request;
use Exception;

class AuthMiddleware extends BaseMiddleware
{
   public function execute(Request $request)
   {
      $token = $request->getBearerToken();
      if (!isset($_SESSION['token']) || $_SESSION['token'] !== $token) {
         http_response_code(403);
         throw new Exception('INVALID TOKEN - ACCESS DENIED');
      }
   }
}
