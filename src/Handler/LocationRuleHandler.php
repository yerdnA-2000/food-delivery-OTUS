<?php

namespace App\Handler;

use App\Entity\LocationRule;
use App\Entity\Rule;

class LocationRuleHandler implements RuleHandlerInterface
{
    public function supports(Rule $rule): bool
    {
        return $rule instanceof LocationRule;
    }

    public function handle(Rule $rule, RuleContext $context): ?string
    {
        /** @var LocationRule $rule */

        // feature

        return null;
    }
}