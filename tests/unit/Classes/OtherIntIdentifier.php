<?php
declare(strict_types=1);

namespace FireMidge\Tests\Identifier\Unit\Classes;

use FireMidge\Identifier\Identifier;

class OtherIntIdentifier implements Identifier
{
    public function __construct(private string $value) {}

    public function toString() : string
    {
        return $this->value;
    }

    public function __toString() : string
    {
        return $this->value;
    }

    public function isEqualTo(Identifier $id) : bool
    {
        return false;
    }

    public function toInt() : int
    {
        return (int) $this->value;
    }
}