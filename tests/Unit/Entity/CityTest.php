<?php

namespace App\Tests\Unit\Entity;

use App\Entity\City;
use App\Entity\Region;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $city = new City();

        $city->setName('Moscow');
        self::assertEquals('Moscow', $city->getName());

        $region = new Region();
        $city->setRegion($region);
        self::assertSame($region, $city->getRegion());
    }
}