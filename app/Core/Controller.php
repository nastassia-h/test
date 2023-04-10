<?php

declare(strict_types=1);

namespace App\Core;

use App\Middlewares\BaseMiddleware;

/**
 * Class Controller
 *
 * @package App\Core
 */
class Controller
{
   public array $middlewares = [];

   public function registerMiddleware(BaseMiddleware $middleware)
   {
      $this->middlewares[] = $middleware;
   }
}
