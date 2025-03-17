<?php

namespace App\Service;

use App\Entity\RedirectRule;
use App\Handler\RuleContext;
use App\Handler\RuleChainHandler;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class RedirectService
{
    public function __construct(
        protected ManagerRegistry  $doctrine,
        protected RuleChainHandler $ruleChainHandler,
    ) {
    }

    public function getRedirectUrl(Request $request): ?string
    {
        if (!$restaurantSlug = $request->attributes->get('restaurantSlug')) {
            return null;
        }

        $context = new RuleContext($request);

        $redirectRules = $this->doctrine
            ->getRepository(RedirectRule::class)
            ->findByRestaurantSlug($restaurantSlug);

        foreach ($redirectRules as $redirectRule) {
            $url = $this->ruleChainHandler->process($redirectRule, $context);

            if ($url) {
                return $url;
            }
        }

        return null;
    }
}