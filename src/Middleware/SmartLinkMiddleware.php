<?php

namespace App\Middleware;

use App\Service\RedirectService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class SmartLinkMiddleware implements HttpKernelInterface
{
    public function __construct(
        private readonly HttpKernelInterface $kernel,
        private RedirectService $redirectService,
    ) {
    }

    #[\Override]
    public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
    {
        $redirectUrl = $this->redirectService->getRedirectUrl($request);

        if (null !== $redirectUrl) {
            return new Response('', Response::HTTP_FOUND, ['Location' => $redirectUrl]);
        }

        return $this->kernel->handle($request, $type, $catch);
    }
}