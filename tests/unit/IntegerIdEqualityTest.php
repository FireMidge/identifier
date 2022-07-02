<?php
declare(strict_types=1);

namespace FireMidge\Tests;

use FireMidge\Identifier\Implementation\IntegerId;
use FireMidge\Identifier\Implementation\UuidId;
use PHPUnit\Framework\TestCase;

class IntegerIdEqualityTest extends TestCase
{
    /**
     * Testing that two instances of the same class can be compared with each other.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfSameClassAreEqualUsingFromString() : void
    {
        $value = '175';

        $instance1 = CId::fromString($value);
        $instance2 = CId::fromString($value);

        $this->assertTrue($instance1->isEqualTo($instance2));
        $this->assertTrue($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that two instances of the same class can be compared with each other.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfSameClassAreEqual() : void
    {
        $value = 178;

        $instance1 = CId::fromInt($value);
        $instance2 = CId::fromInt($value);

        $this->assertTrue($instance1->isEqualTo($instance2));
        $this->assertTrue($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that two instances of the same class can be compared with each other.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfSameClassAreEqualUsingBothFromIntAndFromString() : void
    {
        $instance1 = CId::fromInt(178);
        $instance2 = CId::fromString('178');

        $this->assertTrue($instance1->isEqualTo($instance2));
        $this->assertTrue($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that instances of two different IntId classes can be compared with each other.
     * NOTE that this is likely going to change in the future but will be released
     * as a breaking change with a new major version.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfDifferentIntClassAreEqualUsingFromString() : void
    {
        $value = '8756';

        $instanceA = CId::fromString($value);
        $instanceB = DId::fromString($value);

        $this->assertTrue($instanceA->isEqualTo($instanceB));
        $this->assertTrue($instanceB->isEqualTo($instanceA));
    }

    /**
     * Testing that instances of two different IntId classes can be compared with each other.
     * NOTE that this is likely going to change in the future but will be released
     * as a breaking change with a new major version.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfDifferentIntClassAreEqual() : void
    {
        $value = 8756;

        $instanceA = CId::fromInt($value);
        $instanceB = DId::fromInt($value);

        $this->assertTrue($instanceA->isEqualTo($instanceB));
        $this->assertTrue($instanceB->isEqualTo($instanceA));
    }

    /**
     * Testing that instances of two different Identifier classes are not equal.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfDifferentIdClassesAreEqual() : void
    {
        $instance1 = UuidId::fromString('b27478fc-c372-4a3e-bf91-639de3d50ea4');
        $instance2 = IntegerId::fromInt(123);

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that instances of two different Identifier classes are not equal.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfDifferentIdClassesAreEqualUsingFromString() : void
    {
        $instance1 = UuidId::fromString('b27478fc-c372-4a3e-bf91-639de3d50ea4');
        $instance2 = IntegerId::fromString('123');

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that instances of the same Int ID class but with different values are
     * not equal to one another.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfDifferentIntsAreNotEqualUsingFromString() : void
    {
        $instance1 = CId::fromString('10');
        $instance2 = CId::fromString('11');

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that instances of the same Int ID class but with different values are
     * not equal to one another.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfDifferentIntsAreNotEqual() : void
    {
        $instance1 = CId::fromInt(10);
        $instance2 = CId::fromInt(11);

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that instances of different Int ID classes and with different values are
     * not equal to one another.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testInstancesOfDifferentIntClassesAndDifferentIntsAreNotEqual() : void
    {
        $instance1 = CId::fromString('10');
        $instance2 = DId::fromString('11');

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that the convertFrom method works from A to B.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::convertFrom
     * @covers \FireMidge\Identifier\Implementation\IntegerId::toInt
     */
    public function testConvertFromAToBSuccessful() : void
    {
        $value     = 955;
        $instance1 = CId::fromInt($value);
        $instance2 = DId::convertFrom($instance1);

        $this->assertSame($value, $instance2->toInt());
    }

    /**
     * Testing that an instance which has been converted from AId to BId
     * is equal to another BId instance with the same value.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::convertFrom
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testConvertedInstanceIsEqual() : void
    {
        $value      = 7065;
        $instance1 = CId::fromInt($value);
        $instance2 = DId::convertFrom($instance1);
        $instance3 = DId::fromInt($value);

        $this->assertTrue($instance2->isEqualTo($instance3));
        $this->assertTrue($instance3->isEqualTo($instance2));
    }

    /**
     * Testing that an instance which has been converted from AId to BId
     * is equal to another BId instance with the same value.
     * NOTE this is likely going to change in another major version.
     *
     * @covers \FireMidge\Identifier\Implementation\IntegerId::convertFrom
     * @covers \FireMidge\Identifier\Implementation\IntegerId::isEqualTo
     */
    public function testConvertedInstanceIsEqualToOldInstance() : void
    {
        $instance1 = CId::fromInt(7065);
        $instance2 = DId::convertFrom($instance1);

        $this->assertTrue($instance2->isEqualTo($instance1));
        $this->assertTrue($instance1->isEqualTo($instance2));
    }
}

class CId extends IntegerId {}
class DId extends IntegerId {}