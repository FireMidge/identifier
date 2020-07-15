<?php
declare(strict_types=1);

namespace FireMidge\Identifier;

interface Identifier
{
    public function toString() : \string;

    public function __toString() : \string;

    public function isEqualTo(Identifier $id) : \bool;
}