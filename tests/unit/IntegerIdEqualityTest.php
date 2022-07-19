<?php
declare(strict_types=1);

namespace FireMidge\Tests\Identifier\Unit;

use FireMidge\Identifier\Implementation\IntegerId;
use FireMidge\Identifier\Implementation\UuidId;
use FireMidge\Tests\Identifier\Unit\Classes\OtherIntIdentifier;
use FireMidge\Tests\Identifier\Unit\Classes\OtherStringIdentifier;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FireMidge\Identifier\Implementation\IntegerId
 */
class IntegerIdEqualityTest extends TestCase
{
    /**
     * Testing that two instances of the same class can be compared with each other.
     */
    public function testInstancesOfSameClassAreEqualUsingFromString() : void
    {
        $value = '175';

        $instance1 = CId::fromString($value);
        $instance2 = CId::fromString($value);

        $this->assertTrue($instance1->isEqualTo($instance2));
        $this->assertTrue($instance2->isEqualTo($instance1));

        $this->assertFalse($instance1->isNotEqualTo($instance2));
        $this->assertFalse($instance2->isNotEqualTo($instance1));
    }

    /**
     * Testing that two instances of the same class can be compared with each other.
     */
    public function testInstancesOfSameClassAreEqual() : void
    {
        $value = 178;

        $instance1 = CId::fromInt($value);
        $instance2 = CId::fromInt($value);

        $this->assertTrue($instance1->isEqualTo($instance2));
        $this->assertTrue($instance2->isEqualTo($instance1));

        $this->assertFalse($instance1->isNotEqualTo($instance2));
        $this->assertFalse($instance2->isNotEqualTo($instance1));
    }

    /**
     * Testing that two instances of the same class can be compared with each other.
     */
    public function testInstancesOfSameClassAreEqualUsingBothFromIntAndFromString() : void
    {
        $instance1 = CId::fromInt(178);
        $instance2 = CId::fromString('178');

        $this->assertTrue($instance1->isEqualTo($instance2));
        $this->assertTrue($instance2->isEqualTo($instance1));

        $this->assertFalse($instance1->isNotEqualTo($instance2));
        $this->assertFalse($instance2->isNotEqualTo($instance1));
    }

    /**
     * Testing that instances of two different IntId classes can be compared with each other.
     * They are considered equal only when strict check is false.
     */
    public function testInstancesOfDifferentIntClassAreEqualUsingFromStringWithNoStrictCheck() : void
    {
        $value = '8756';

        $instanceA = CId::fromString($value);
        $instanceB = DId::fromString($value);

        $this->assertTrue($instanceA->isEqualTo($instanceB, false));
        $this->assertTrue($instanceB->isEqualTo($instanceA, false));

        $this->assertFalse($instanceA->isNotEqualTo($instanceB, false));
        $this->assertFalse($instanceB->isNotEqualTo($instanceA, false));
    }

    /**
     * Testing that instances of two different IntId classes can be compared with each other.
     * They are not considered equal when performing the default strict check.
     */
    public function testInstancesOfDifferentIntClassAreNotEqualUsingFromString() : void
    {
        $value = '8756';

        $instanceA = CId::fromString($value);
        $instanceB = DId::fromString($value);

        $this->assertFalse($instanceA->isEqualTo($instanceB));
        $this->assertFalse($instanceB->isEqualTo($instanceA));

        $this->assertTrue($instanceA->isNotEqualTo($instanceB));
        $this->assertTrue($instanceB->isNotEqualTo($instanceA));
    }

    /**
     * Testing that instances of two different IntId classes can be compared with each other.
     * They are considered equal only when strict check is false.
     */
    public function testInstancesOfDifferentIntClassAreEqualWithoutStrictCheck() : void
    {
        $value = 8756;

        $instanceA = CId::fromInt($value);
        $instanceB = DId::fromInt($value);

        $this->assertTrue($instanceA->isEqualTo($instanceB, false));
        $this->assertTrue($instanceB->isEqualTo($instanceA, false));

        $this->assertFalse($instanceA->isNotEqualTo($instanceB, false));
        $this->assertFalse($instanceB->isNotEqualTo($instanceA, false));
    }

    /**
     * Testing that instances of two different IntId classes can be compared with each other.
     * They are not considered equal when performing the default strict check.
     */
    public function testInstancesOfDifferentIntClassAreNotEqual() : void
    {
        $value = 8756;

        $instanceA = CId::fromInt($value);
        $instanceB = DId::fromInt($value);

        $this->assertFalse($instanceA->isEqualTo($instanceB));
        $this->assertFalse($instanceB->isEqualTo($instanceA));

        $this->assertTrue($instanceA->isNotEqualTo($instanceB));
        $this->assertTrue($instanceB->isNotEqualTo($instanceA));
    }

    /**
     * Testing that instances of two different Identifier classes are not equal.
     */
    public function testInstancesOfDifferentIdClassesAreEqual() : void
    {
        $instance1 = UuidId::fromString('b27478fc-c372-4a3e-bf91-639de3d50ea4');
        $instance2 = IntegerId::fromInt(123);

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));

        $this->assertTrue($instance1->isNotEqualTo($instance2));
        $this->assertTrue($instance2->isNotEqualTo($instance1));
    }

    /**
     * Testing that instances of two different Identifier classes are not equal.
     */
    public function testInstancesOfDifferentIdClassesAreEqualUsingFromString() : void
    {
        $instance1 = UuidId::fromString('b27478fc-c372-4a3e-bf91-639de3d50ea4');
        $instance2 = IntegerId::fromString('123');

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));

        $this->assertTrue($instance1->isNotEqualTo($instance2));
        $this->assertTrue($instance2->isNotEqualTo($instance1));
    }

    /**
     * Testing that instances of the same Int ID class but with different values are
     * not equal to one another.
     */
    public function testInstancesOfDifferentIntsAreNotEqualUsingFromString() : void
    {
        $instance1 = CId::fromString('10');
        $instance2 = CId::fromString('11');

        $this->assertFalse($instance1->isEqualTo($instance2), 'Instance1 -> Instance2');
        $this->assertFalse($instance2->isEqualTo($instance1), 'Instance2 -> Instance1');

        $this->assertTrue($instance1->isNotEqualTo($instance2));
        $this->assertTrue($instance2->isNotEqualTo($instance1));
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

        $this->assertTrue($instance1->isNotEqualTo($instance2));
        $this->assertTrue($instance2->isNotEqualTo($instance1));
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

        $this->assertTrue($instance1->isNotEqualTo($instance2));
        $this->assertTrue($instance2->isNotEqualTo($instance1));
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

        $this->assertFalse($instance2->isNotEqualTo($instance3));
        $this->assertFalse($instance3->isNotEqualTo($instance2));
    }

    /**
     * Testing that an instance which has been converted from CId to DId
     * is equal to another DId instance with the same value but only with strict check disabled.
     */
    public function testConvertedInstanceIsNotEqualToOldInstance() : void
    {
        $instance1 = CId::fromInt(7065);
        $instance2 = DId::convertFrom($instance1);

        $this->assertFalse($instance2->isEqualTo($instance1));
        $this->assertFalse($instance1->isEqualTo($instance2));

        $this->assertTrue($instance2->isNotEqualTo($instance1));
        $this->assertTrue($instance1->isNotEqualTo($instance2));
    }

    /**
     * Testing that an instance which has been converted from CId to DId
     * is equal to another DId instance with the same value but only with strict check disabled.
     */
    public function testConvertedInstanceIsEqualToOldInstanceWithoutStrictCheck() : void
    {
        $instance1 = CId::fromInt(7065);
        $instance2 = DId::convertFrom($instance1);

        $this->assertTrue($instance2->isEqualTo($instance1, false));
        $this->assertTrue($instance1->isEqualTo($instance2, false));

        $this->assertFalse($instance2->isNotEqualTo($instance1, false));
        $this->assertFalse($instance1->isNotEqualTo($instance2, false));
    }

    public function testComparingWithOtherIntIdentifierNotEqual() : void
    {
        $value = '500';

        $instance1 = IntegerId::fromString($value);
        $instance2 = new OtherIntIdentifier($value);

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertTrue($instance1->isNotEqualTo($instance2));
    }

    public function testComparingWithOtherIntIdentifierEqualWithoutStrictCheck() : void
    {
        $value = '500';

        $instance1 = IntegerId::fromString($value);
        $instance2 = new OtherIntIdentifier($value);

        $this->assertTrue($instance1->isEqualTo($instance2, false));
        $this->assertFalse($instance1->isNotEqualTo($instance2, false));
    }

    /**
     * Test that an object of another class implementing Identifier, but which does not have a toInt
     * method, is not considered equal even when they have the same string value.
     */
    public function testComparingWithOtherStringIdentifierNotEqualWithoutStrictCheck() : void
    {
        $value = '500';

        $instance1 = IntegerId::fromString($value);
        $instance2 = new OtherStringIdentifier($value);

        $this->assertFalse($instance1->isEqualTo($instance2, false));
        $this->assertTrue($instance1->isNotEqualTo($instance2, false));
    }

    /**
     * Test that an object of another class implementing Identifier, but which does not have a toInt
     * method, is not considered equal even when they have the same string value.
     */
    public function testComparingWithOtherStringIdentifierNotEqual() : void
    {
        $value = '500';

        $instance1 = IntegerId::fromString($value);
        $instance2 = new OtherStringIdentifier($value);

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertTrue($instance1->isNotEqualTo($instance2));
    }
}

class CId extends IntegerId {}
class DId extends IntegerId {}
