<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class RedirectService
{
    public function getRedirectUrl(Request $request): ?string
    {
        $restaurantSlug = $request->attributes->get('restaurantSlug');

        if (!$restaurantSlug) {
            return null;
        }

        return '';
    }
}