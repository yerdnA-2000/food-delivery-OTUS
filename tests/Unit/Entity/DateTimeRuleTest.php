<?php

namespace App\Tests\Unit\Entity;

use App\Entity\DateTimeRule;
use PHPUnit\Framework\TestCase;

class DateTimeRuleTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $dateTimeRule = new DateTimeRule();
        $startDateTime = new \DateTime('2025-03-01 06:00:00');
        $endDateTime = new \DateTime('2025-03-01 11:00:00');

        $dateTimeRule->setStartDateTime($startDateTime);
        self::assertEquals($startDateTime, $dateTimeRule->getStartDateTime());

        $dateTimeRule->setEndDateTime($endDateTime);
        self::assertEquals($endDateTime, $dateTimeRule->getEndDateTime());
    }
}