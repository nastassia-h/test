<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class Response
 *
 * @package App\core
 */
class Response
{
    /**
     * @param int $code
     * @return void
     */
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }
}