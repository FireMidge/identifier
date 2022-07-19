<?php
declare(strict_types=1);

namespace FireMidge\Identifier\Implementation;

use FireMidge\Identifier\Exception\InvalidUuid;
use FireMidge\Identifier\Identifier;
use FireMidge\Identifier\UuidIdentifier;
use function chr;
use function ord;
use function vsprintf;
use function str_split;
use function bin2hex;
use function preg_match;

class UuidId implements UuidIdentifier
{
    private function __construct(private string $uuid)
    {
        if (! static::isValid($uuid)) {
            throw new InvalidUuid($uuid);
        }
    }

    public function toString() : string
    {
        return $this->uuid;
    }

    public function __toString() : string
    {
        return $this->uuid;
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

        return $this->uuid === $id->toString();
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

    public static function fromString(string $uuid) : static
    {
        return new static($uuid);
    }

    public static function fromStringOrNull(?string $uuid) : ?static
    {
        if ($uuid === null) {
            return null;
        }

        return new static($uuid);
    }

    final public static function generate() : static
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return new static(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
    }

    public static function convertFrom(UuidIdentifier $otherUuidInstance) : static
    {
        return static::fromString($otherUuidInstance->toString());
    }

    private static function isValid(string $uuid) : bool
    {
        $regEx = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        return (preg_match($regEx, $uuid) === 1);
    }
}