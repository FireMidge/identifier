<?php
declare(strict_types=1);

namespace FireMidge\Identifier\Exception;

use RuntimeException;
use Throwable;

class InvalidUuid extends RuntimeException
{
    public function __construct(string $uuid, int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('"%s" is not a valid UUID', $uuid);
        parent::__construct($message, $code, $previous);
    }
}