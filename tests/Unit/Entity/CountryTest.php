<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $country = new Country();

        $country->setName('Russia');
        self::assertEquals('Russia', $country->getName());

        $country->setCode('RU');
        self::assertEquals('RU', $country->getCode());
    }
}