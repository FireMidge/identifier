<?php
declare(strict_types=1);

namespace FireMidge\Tests\Identifier\Unit;

use FireMidge\Identifier\Implementation\UuidId;
use PHPUnit\Framework\TestCase;
use FireMidge\Identifier\Exception\InvalidUuid;

class UuidIdTest extends TestCase
{
    public function validUuidProvider() : array
    {
        return [
            [ '42c1954d-22fa-488e-a077-752744a2bcd1' ],
            [ 'fae1f482-acb8-48db-8ffb-01f733c5f932' ],
            [ '683628c0-912c-4870-b0ee-2974908df698' ],
        ];
    }

    /**
     * Testing that the fromString factory method works as expected with a valid string.
     *
     * @dataProvider validUuidProvider
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::fromString
     * @covers \FireMidge\Identifier\Implementation\UuidId::toString
     */
    public function testFromStringWithValidUuid(string $validUuid) : void
    {
        $instance = UuidId::fromString($validUuid);
        $this->assertSame($validUuid, $instance->toString());
    }

    /**
     * Testing that the fromStringOrNull factory method works
     * as expected with a valid string.
     *
     * @dataProvider validUuidProvider
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::fromStringOrNull
     */
    public function testFromStringOrNullWithValidUuid(string $validUuid) : void
    {
        $instance = UuidId::fromStringOrNull($validUuid);
        $this->assertSame($validUuid, $instance->toString());
    }

    /**
     * Testing that the fromStringOrNull factory method works when passing NULL.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::fromStringOrNull
     */
    public function testFromStringOrNullWithNull() : void
    {
        $instance = UuidId::fromStringOrNull(null);
        $this->assertNull($instance);
    }

    /**
     * Testing that the magic __toString works as expected.
     *
     * @dataProvider validUuidProvider
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::__toString
     */
    public function testFromStringConverter(string $validUuid) : void
    {
        $instance = UuidId::fromString($validUuid);
        $this->assertEquals($validUuid, $instance);
    }

    public function invalidUuidProvider() : array
    {
        return [
            'tooLong'              => [ '683628c0-912c-4870-b0ee-2974908df69815f' ],
            'tooShort'             => [ '683628c0-912c-4870-b0ee' ],
            'noDashes'             => [ '683628c0912c4870b0ee2974908df698' ],
            'tooManyDashesInBack'  => [ '683628c0-912c-4870-b0ee-2974-908df698' ],
            'tooManyDashesInFront' => [ '683-628c0-912c-4870-b0ee-2974908df698' ],
            'anyString'            => [ 'invalid' ],
            'emptyString'          => [ '' ],
            'whitespace'           => [ ' ' ],
        ];
    }

    /**
     * Testing that an invalid string passed to the fromString factory method
     * throws an exception.
     *
     * @dataProvider invalidUuidProvider
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::fromString
     */
    public function testFromStringWithInvalidUuid(string $invalidUuid) : void
    {
        $this->expectException(InvalidUuid::class);
        UuidId::fromString($invalidUuid);
    }

    /**
     * Testing the exception message is as expected for an invalid UUID.
     *
     * @dataProvider invalidUuidProvider
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::fromString
     */
    public function testFromStringExceptionMessage(string $invalidUuid) : void
    {
        $this->expectExceptionMessage('"' . $invalidUuid . '" is not a valid UUID');
        UuidId::fromString($invalidUuid);
    }

    /**
     * Testing that an invalid string passed to the factory method throws an exception.
     *
     * @dataProvider invalidUuidProvider
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::fromStringOrNull
     */
    public function testFromStringOrNullWithInvalidUuid(string $invalidUuid) : void
    {
        $this->expectException(InvalidUuid::class);
        UuidId::fromStringOrNull($invalidUuid);
    }

    /**
     * Testing the exception message is as expected for an invalid UUID.
     *
     * @dataProvider invalidUuidProvider
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::fromStringOrNull
     */
    public function testFromStringOrNullExceptionMessage(string $invalidUuid) : void
    {
        $this->expectExceptionMessage('"' . $invalidUuid . '" is not a valid UUID');
        UuidId::fromStringOrNull($invalidUuid);
    }

    /**
     * Testing that the generate method works as expected.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::generate
     * @depends testFromStringWithValidUuid
     */
    public function testGenerateSuccessful() : void
    {
        $generatedUuid = UuidId::generate();
        $instance      = UuidId::fromString($generatedUuid->toString());

        $this->assertSame($generatedUuid->toString(), $instance->toString());
    }
}