<?php
declare(strict_types=1);

namespace FireMidge\Tests;

use FireMidge\Identifier\Exception\NotAnInteger;
use FireMidge\Identifier\Implementation\IntegerId;
use PHPUnit\Framework\TestCase;

class IntegerIdTest extends TestCase
{
    public function validIntegerProvider() : array
    {
        return [
            [ 0 ],
            [ 1 ],
            [ 10 ],
            [ 523 ],
            [ 10000000 ],
            [ -1 ],
        ];
    }

    public function validStringProvider() : array
    {
        return [
            [ '0' ],
            [ '1' ],
            [ '10' ],
            [ '523' ],
            [ '10000000' ],
            [ '-1' ],
        ];
    }

    public function validStringToIntProvider() : array
    {
        return [
            [ '0', 0 ],
            [ '1', 1 ],
            [ '10', 10 ],
            [ '523', 523 ],
            [ '10000000', 10000000 ],
            [ '-1', -1 ],
        ];
    }

    /**
     * Testing that the factory method works as expected with a valid value.
     *
     * @dataProvider validIntegerProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromInt
     * @covers \FireMidge\Identifier\Implementation\IntegerId::toInt
     */
    public function testFromIntWithValidValue(int $validValue) : void
    {
        $instance = IntegerId::fromInt($validValue);
        $this->assertSame($validValue, $instance->toInt());
    }

    /**
     * Testing that the factory method works as expected with a valid value.
     *
     * @dataProvider validIntegerProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromIntOrNull
     */
    public function testFromIntOrNullWithValidValue(?int $validValue) : void
    {
        $instance = IntegerId::fromIntOrNull($validValue);
        $this->assertSame($validValue, $instance->toInt());
    }

    /**
     * Testing that the factory method works as expected with NULL.
     *
     * @dataProvider validIntegerProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromIntOrNull
     */
    public function testFromIntOrNullWithNull() : void
    {
        $instance = IntegerId::fromIntOrNull(null);
        $this->assertNull($instance);
    }

    /**
     * Testing that the factory method works as expected with a valid value.
     *
     * @dataProvider validStringProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromString
     * @covers \FireMidge\Identifier\Implementation\IntegerId::toString
     */
    public function testFromStringWithValidValue(string $validValue) : void
    {
        $instance = IntegerId::fromString($validValue);
        $this->assertSame($validValue, $instance->toString());
    }

    /**
     * Testing that the factory method works as expected with a valid value.
     *
     * @dataProvider validStringProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromStringOrNull
     */
    public function testFromStringOrNullWithValidValue(?string $validValue) : void
    {
        $instance = IntegerId::fromStringOrNull($validValue);
        $this->assertSame($validValue, $instance->toString());
    }

    /**
     * Testing that the factory method works as expected with NULL.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromStringOrNull
     */
    public function testFromStringOrNullWithNull() : void
    {
        $instance = IntegerId::fromStringOrNull(null);
        $this->assertNull($instance);
    }

    /**
     * Testing that the magic __toString works as expected.
     *
     * @dataProvider validStringProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::__toString
     */
    public function testFromStringConverter(string $validUuid) : void
    {
        $instance = IntegerId::fromString($validUuid);
        $this->assertEquals($validUuid, $instance);
    }

    /**
     * @dataProvider validStringToIntProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::toInt
     */
    public function testFromStringComparesToInt(string $validString, int $expectedInt) : void
    {
        $instance = IntegerId::fromString($validString);
        $this->assertEquals($expectedInt, $instance->toInt());
    }

    /**
     * @dataProvider validStringToIntProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::toInt
     */
    public function testFromIntComparesToString(string $expectedString, int $validInt) : void
    {
        $instance = IntegerId::fromInt($validInt);
        $this->assertEquals($expectedString, $instance->toString());
    }

    public function invalidStringProvider() : array
    {
        return [
            [ 'else' ],
            [ 'else15' ],
            [ '15t' ],
            [ '0t' ],
            [ '10.75' ],
            [ '10.0' ],
            [ '~1' ],
            [ '01' ],
        ];

    }

    /**
     * @dataProvider invalidStringProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromString
     */
    public function testFromStringExceptionClass(string $invalidValue) : void
    {
        $this->expectException(NotAnInteger::class);
        IntegerId::fromString($invalidValue);
    }

    /**
     * @dataProvider invalidStringProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromString
     */
    public function testFromStringExceptionMessage(string $invalidValue) : void
    {
        $this->expectExceptionMessage('"' . $invalidValue . '" is not a valid integer value');
        IntegerId::fromString($invalidValue);
    }

    /**
     * @dataProvider invalidStringProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromString
     */
    public function testFromStringOrNullExceptionClass(string $invalidValue) : void
    {
        $this->expectException(NotAnInteger::class);
        IntegerId::fromStringOrNull($invalidValue);
    }

    /**
     * @dataProvider invalidStringProvider
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::fromString
     */
    public function testFromStringOrNullExceptionMessage(string $invalidValue) : void
    {
        $this->expectExceptionMessage('"' . $invalidValue . '" is not a valid integer value');
        IntegerId::fromStringOrNull($invalidValue);
    }
}