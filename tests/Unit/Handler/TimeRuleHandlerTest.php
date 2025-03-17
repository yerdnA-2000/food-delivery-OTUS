<?php

namespace App\Tests\Unit\Handler;

use App\Entity\RedirectRule;
use App\Entity\TimeRule;
use App\Handler\RuleContext;
use App\Handler\TimeRuleHandler;
use DateTime;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class TimeRuleHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        $handler = new TimeRuleHandler();

        $request = Request::create('/restaurant/some');
        $request->attributes->set('_route', 'restaurant_view');
        $request->attributes->set('restaurantSlug', 'some');

        $redirectRule = new RedirectRule();
        $redirectRule->setRedirectUrl('dinner');

        $timeRule = new TimeRule();
        $timeRule->setStartTime(new DateTime('09:00:00', new DateTimeZone('UTC')));
        $timeRule->setEndTime(new DateTime('18:00:00', new DateTimeZone('UTC')));
        $timeRule->setRedirectRule($redirectRule);

        $context = new RuleContext($request);
        $context->setTimezone('Europe/Moscow'); // UTC+3

        self::assertNotNull($handler->handle($timeRule, $context));

        $timeRule->setStartTime(new DateTime('19:00:00', new DateTimeZone('UTC')));
        $timeRule->setEndTime(new DateTime('20:00:00', new DateTimeZone('UTC')));
        self::assertNull($handler->handle($timeRule, $context));
    }
}