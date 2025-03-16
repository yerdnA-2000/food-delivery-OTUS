<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Rule;
use App\Entity\RedirectRule;
use PHPUnit\Framework\TestCase;

class RuleTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $rule = self::getMockForAbstractClass(Rule::class);
        $redirectRule = new RedirectRule();

        $rule->setRedirectRule($redirectRule);
        self::assertSame($redirectRule, $rule->getRedirectRule());
    }
}