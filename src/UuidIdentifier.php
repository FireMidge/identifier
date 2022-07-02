<?php
declare(strict_types=1);

namespace FireMidge\Identifier;

interface UuidIdentifier extends Identifier
{
    public static function fromString(string $uuid) : self;

    public static function fromStringOrNull(?string $uuid) : ?self;

    public static function generate() : self;

    public static function convertFrom(UuidIdentifier $otherIdentifier) : self;
}