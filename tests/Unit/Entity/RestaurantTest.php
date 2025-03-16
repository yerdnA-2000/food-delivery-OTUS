<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Restaurant;
use App\Entity\RedirectRule;
use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $restaurant = new Restaurant();

        $restaurant->setName('Best Restaurant');
        self::assertEquals('Best Restaurant', $restaurant->getName());

        $restaurant->setSlug('best-restaurant');
        self::assertEquals('best-restaurant', $restaurant->getSlug());
    }

    public function testAddAndRemoveRedirectRule(): void
    {
        $restaurant = new Restaurant();
        $redirectRule = new RedirectRule();

        $restaurant->addRedirectRule($redirectRule);
        self::assertTrue($restaurant->getRedirectRules()->contains($redirectRule));
        self::assertSame($restaurant, $redirectRule->getRestaurant());

        $restaurant->removeRedirectRule($redirectRule);
        self::assertFalse($restaurant->getRedirectRules()->contains($redirectRule));
    }
}