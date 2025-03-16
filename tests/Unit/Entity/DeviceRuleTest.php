<?php

namespace App\Tests\Unit\Entity;

use App\Entity\DeviceRule;
use PHPUnit\Framework\TestCase;

class DeviceRuleTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $deviceRule = new DeviceRule();

        self::assertNull($deviceRule->getDeviceType());

        $deviceRule->setDeviceType('mobile');
        self::assertEquals('mobile', $deviceRule->getDeviceType());
    }
}