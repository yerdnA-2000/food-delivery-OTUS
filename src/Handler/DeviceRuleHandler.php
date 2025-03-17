<?php

namespace App\Handler;

use App\Entity\DeviceRule;
use App\Entity\Rule;

class DeviceRuleHandler implements RuleHandlerInterface
{
    public function supports(Rule $rule): bool
    {
        return $rule instanceof DeviceRule;
    }

    public function handle(Rule $rule, RuleContext $context): ?string
    {
        /** @var DeviceRule $rule */

        // feature

        return null;
    }
}