<?php

namespace App\Handler;

use App\Entity\DateTimeRule;
use App\Entity\Rule;

class DateTimeRuleHandler implements RuleHandlerInterface
{
    public function supports(Rule $rule): bool
    {
        return $rule instanceof DateTimeRule;
    }

    public function handle(Rule $rule, RuleContext $context): ?string
    {
        /** @var DateTimeRule $rule */

        // feature

        return null;
    }
}