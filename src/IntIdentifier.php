<?php
declare(strict_types=1);

namespace FireMidge\Identifier;

interface IntIdentifier extends Identifier
{
    public static function convertFrom(IntIdentifier $otherIdentifier) : static;

    public static function fromInt(int $id) : static;

    public function toInt() : int;
}