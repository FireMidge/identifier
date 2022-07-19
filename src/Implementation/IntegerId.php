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
    private function __construct(private int $id) {}

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

    /**
     * If $strictCheck is true, this method will only return true if $id
     * does not just have the same value but is also of the same concrete
     * Identifier class as $this.
     * If $strictCheck is false, this method returns true if $id has the same value
     * regardless of concrete class.
     */
    public function isEqualTo(Identifier $id, bool $strictCheck = true) : bool
    {
        if ($strictCheck && ! is_a($id, static::class)) {
            return false;
        }

        if (! method_exists($id, 'toInt')) {
            return false;
        }

        return $this->id === $id->toInt();
    }

    /**
     * If $strictCheck is true, this method returns false if $id either has a different
     * value or is of a different concrete Identifier class.
     * If $strictCheck is false, this method returns false only if $id has a different value.
     */
    public function isNotEqualTo(Identifier $id, bool $strictCheck = true) : bool
    {
        return ! $this->isEqualTo($id, $strictCheck);
    }

    public function toInt() : int
    {
        return $this->id;
    }
}