<?php

namespace App\Service;

use App\Entity\RedirectRule;
use App\Handler\RuleChainHandler;
use App\Handler\RuleContext;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class RestaurantRedirector implements RedirectorInterface
{
    public function __construct(
        protected ManagerRegistry  $doctrine,
        protected RuleChainHandler $ruleChainHandler,
    ) {
    }

    public function supports(Request $request): bool
    {
        return !!$request->attributes->get('restaurantSlug');
    }

    public function getRedirectUrl(Request $request): ?string
    {
        /** @var string $restaurantSlug */
        $restaurantSlug = $request->attributes->get('restaurantSlug');

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