<?php
declare(strict_types=1);

namespace FireMidge\Identifier\Implementation;

use FireMidge\Identifier\Exception\NotAnInteger;
use FireMidge\Identifier\Identifier;
use FireMidge\Identifier\IntIdentifier;

/**
 * An integer identifier.
 */
class IntegerId implements IntIdentifier
{
    private int $id;

    private function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromInt(int $id) : static
    {
        return new static($id);
    }

    public static function fromIntOrNull(?int $id) : ?static
    {
        if ($id === null) {
            return null;
        }

        return new static($id);
    }

    public static function fromString(string $id) : static
    {
        if ((string) (int) $id !== $id) {
            throw new NotAnInteger($id);
        }

        return new static((int) $id);
    }

    public static function fromStringOrNull(?string $id) : ?static
    {
        if ($id === null) {
            return null;
        }

        return static::fromString($id);
    }

    public static function convertFrom(IntIdentifier $otherIdentifier) : static
    {
        return new static($otherIdentifier->toInt());
    }

    public function __toString() : string
    {
        return (string) $this->id;
    }

    public function toString() : string
    {
        return (string) $this->id;
    }

    public function isEqualTo(Identifier $id) : bool
    {
        if (! $id instanceof IntIdentifier) {
            return false;
        }

        return $id->toInt() === $this->id;
    }

    public function toInt() : int
    {
        return $this->id;
    }
}