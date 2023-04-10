<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Request;

abstract class BaseMiddleware
{
   abstract public function execute(Request $request);
}
