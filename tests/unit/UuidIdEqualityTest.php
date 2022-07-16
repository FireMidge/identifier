<?php
declare(strict_types=1);

namespace FireMidge\Tests\Identifier\Unit;

use FireMidge\Identifier\Implementation\IntegerId;
use FireMidge\Identifier\Implementation\UuidId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FireMidge\Identifier\Implementation\UuidId
 */
class UuidIdEqualityTest extends TestCase
{
    /**
     * Testing that two instances of the same UUID class can be compared with each other.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::isEqualTo
     */
    public function testInstancesOfSameClassAreEqual() : void
    {
        $uuid = 'b27478fc-c372-4a3e-bf91-639de3d50ea4';

        $instance1 = AId::fromString($uuid);
        $instance2 = AId::fromString($uuid);

        $this->assertTrue($instance1->isEqualTo($instance2));
        $this->assertTrue($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that instances of two different UUID classes can be compared with each other.
     * NOTE that this is likely going to change in the future but will be released
     * as a breaking change with a new major version.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::isEqualTo
     */
    public function testInstancesOfDifferentUuidClassAreEqual() : void
    {
        $uuid = 'b27478fc-c372-4a3e-bf91-639de3d50ea4';

        $instanceA = AId::fromString($uuid);
        $instanceB = BId::fromString($uuid);

        $this->assertTrue($instanceA->isEqualTo($instanceB));
        $this->assertTrue($instanceB->isEqualTo($instanceA));
    }

    /**
     * Testing that instances of two different Identifier classes are not equal.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::isEqualTo
     */
    public function testInstancesOfDifferentIdClassesAreEqual() : void
    {
        $instance1 = UuidId::fromString('b27478fc-c372-4a3e-bf91-639de3d50ea4');
        $instance2 = IntegerId::fromInt(123);

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that instances of the same UUID class but with different UUIDs are
     * not equal to one another.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::isEqualTo
     */
    public function testInstancesOfDifferentUuidsAreNotEqual() : void
    {
        $instance1 = AId::fromString('b27478fc-c372-4a3e-bf91-639de3d50ea4');
        $instance2 = AId::fromString('b27478fc-c372-4a3e-bf91-639de3d50fff');

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that instances of different UUID classes and with different UUIDs are
     * not equal to one another.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::isEqualTo
     */
    public function testInstancesOfDifferentUuidClassesAndDifferentUuidsAreNotEqual() : void
    {
        $instance1 = AId::fromString('b27478fc-c372-4a3e-bf91-639de3d50ea4');
        $instance2 = BId::fromString('b27478fc-c372-4a3e-bf91-639de3d50fff');

        $this->assertFalse($instance1->isEqualTo($instance2));
        $this->assertFalse($instance2->isEqualTo($instance1));
    }

    /**
     * Testing that the convertFrom method works from A to B.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::convertFrom
     * @covers \FireMidge\Identifier\Implementation\UuidId::toString
     */
    public function testConvertFromAToBSuccessful() : void
    {
        $uuid = '6c102acb-18e9-4cd3-9df2-072a2b4b4faf';
        $instance1 = AId::fromString($uuid);
        $instance2 = BId::convertFrom($instance1);

        $this->assertSame($uuid, $instance2->toString());
    }

    /**
     * Testing that an instance which has been converted from AId to BId
     * is equal to another BId instance with the same UUID.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::convertFrom
     * @covers \FireMidge\Identifier\Implementation\UuidId::isEqualTo
     */
    public function testConvertedInstanceIsEqual() : void
    {
        $uuid = '6c102acb-18e9-4cd3-9df2-072a2b4b4faf';
        $instance1 = AId::fromString($uuid);
        $instance2 = BId::convertFrom($instance1);
        $instance3 = BId::fromString($uuid);

        $this->assertTrue($instance2->isEqualTo($instance3));
        $this->assertTrue($instance3->isEqualTo($instance2));
    }

    /**
     * Testing that an instance which has been converted from AId to BId
     * is equal to another BId instance with the same UUID.
     * NOTE this is likely going to change in another major version.
     *
     * @covers \FireMidge\Identifier\Implementation\UuidId::convertFrom
     * @covers \FireMidge\Identifier\Implementation\UuidId::isEqualTo
     */
    public function testConvertedInstanceIsEqualToOldInstance() : void
    {
        $instance1 = AId::fromString('6c102acb-18e9-4cd3-9df2-072a2b4b4faf');
        $instance2 = BId::convertFrom($instance1);

        $this->assertTrue($instance2->isEqualTo($instance1));
        $this->assertTrue($instance1->isEqualTo($instance2));
    }
}

class AId extends UuidId {}
class BId extends UuidId {}