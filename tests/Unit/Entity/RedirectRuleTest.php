<?php

namespace App\Tests\Unit\Entity;

use App\Entity\RedirectRule;
use App\Entity\Restaurant;
use App\Entity\Rule;
use PHPUnit\Framework\TestCase;

class RedirectRuleTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $redirectRule = new RedirectRule();

        $redirectRule->setRedirectUrl('https://example.com');
        self::assertEquals('https://example.com', $redirectRule->getRedirectUrl());

        $restaurant = new Restaurant();
        $redirectRule->setRestaurant($restaurant);
        self::assertSame($restaurant, $redirectRule->getRestaurant());
    }

    public function testAddAndRemoveRule(): void
    {
        $redirectRule = new RedirectRule();
        $rule = self::getMockForAbstractClass(Rule::class);

        $redirectRule->addRule($rule);
        self::assertTrue($redirectRule->getRules()->contains($rule));
        self::assertSame($redirectRule, $rule->getRedirectRule());

        $redirectRule->removeRule($rule);
        self::assertFalse($redirectRule->getRules()->contains($rule));
    }
}
