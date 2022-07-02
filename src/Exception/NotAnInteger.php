<?php
declare(strict_types=1);

namespace FireMidge\Identifier\Exception;

use InvalidArgumentException;
use Throwable;

class NotAnInteger extends InvalidArgumentException
{
    public function __construct(string $invalidValue, int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('"%s" is not a valid integer value', $invalidValue);
        parent::__construct($message, $code, $previous);
    }
}