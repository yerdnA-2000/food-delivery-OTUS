<?php

namespace App\Tests\Unit\Entity;

use App\Entity\LocationRule;
use App\Entity\Country;
use App\Entity\Region;
use App\Entity\City;
use PHPUnit\Framework\TestCase;

class LocationRuleTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $locationRule = new LocationRule();

        $locationRule->setLatitude(55.7558);
        self::assertEquals(55.7558, $locationRule->getLatitude());

        $locationRule->setLongitude(37.6173);
        self::assertEquals(37.6173, $locationRule->getLongitude());

        $locationRule->setRadius(10.5);
        self::assertEquals(10.5, $locationRule->getRadius());
    }

    public function testAddAndRemoveCountry(): void
    {
        $locationRule = new LocationRule();
        $country = new Country();

        $locationRule->addCountry($country);
        self::assertTrue($locationRule->getCountries()->contains($country));

        $locationRule->removeCountry($country);
        self::assertFalse($locationRule->getCountries()->contains($country));
    }

    public function testAddAndRemoveRegion(): void
    {
        $locationRule = new LocationRule();
        $region = new Region();

        $locationRule->addRegion($region);
        self::assertTrue($locationRule->getRegions()->contains($region));

        $locationRule->removeRegion($region);
        self::assertFalse($locationRule->getRegions()->contains($region));
    }

    public function testAddAndRemoveCity(): void
    {
        $locationRule = new LocationRule();
        $city = new City();

        $locationRule->addCity($city);
        self::assertTrue($locationRule->getCities()->contains($city));

        $locationRule->removeCity($city);
        self::assertFalse($locationRule->getCities()->contains($city));
    }
}