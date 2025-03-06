<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class RequireAuthMiddleware implements HttpKernelInterface
{
    public function __construct(
        private readonly HttpKernelInterface $kernel,
    ) {
    }

    public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
    {
        return $this->kernel->handle($request, $type, $catch);
    }
}