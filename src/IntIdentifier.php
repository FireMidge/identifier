<?php
declare(strict_types=1);

namespace FireMidge\Identifier;

interface IntIdentifier extends Identifier
{
    public static function convertFrom(IntIdentifier $otherIdentifier) : self;

    public static function fromInt(\int $id) : self;

    public function toInt() : \int;
}