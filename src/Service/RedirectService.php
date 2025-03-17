<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class RedirectService
{
    /**
     * @param iterable<RedirectorInterface> $redirectors
     */
    public function __construct(
        private iterable $redirectors,
    ) {
    }

    public function getRedirectUrl(Request $request): ?string
    {
        foreach ($this->redirectors as $redirector) {
            if ($redirector->supports($request)) {
                $url = $redirector->getRedirectUrl($request);

                if ($url) {
                    return $url;
                }
            }
        }

        return null;
    }
}