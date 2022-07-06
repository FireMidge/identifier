<?php
declare(strict_types=1);

namespace FireMidge\Identifier;

interface UuidIdentifier extends Identifier
{
    public static function fromString(string $uuid) : static;

    public static function fromStringOrNull(?string $uuid) : ?static;

    public static function generate() : static;

    public static function convertFrom(UuidIdentifier $otherIdentifier) : static;
}