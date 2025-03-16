<?php

namespace App\Tests\Unit\Entity;

use App\Entity\TimeRule;
use DateTime;
use PHPUnit\Framework\TestCase;

class TimeRuleTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $timeRule = new TimeRule();

        $startTime = new DateTime('09:00:00');
        $timeRule->setStartTime($startTime);
        self::assertEquals($startTime, $timeRule->getStartTime());

        $endTime = new DateTime('18:00:00');
        $timeRule->setEndTime($endTime);
        self::assertEquals($endTime, $timeRule->getEndTime());
    }

    public function testNullValues(): void
    {
        $timeRule = new TimeRule();

        $timeRule->setStartTime(null);
        $timeRule->setEndTime(null);

        self::assertNull($timeRule->getStartTime());
        self::assertNull($timeRule->getEndTime());
    }
}