<?php

namespace App\Tests\Unit\Middleware;

use App\Middleware\SmartLinkMiddleware;
use App\Service\RedirectService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class SmartLinkMiddlewareTest extends TestCase
{
    private SmartLinkMiddleware $middleware;
    private HttpKernelInterface&MockObject $kernel;
    private RedirectService&MockObject $redirectService;

    #[\Override]
    protected function setUp(): void
    {
        $this->kernel = self::createMock(HttpKernelInterface::class);
        $this->redirectService = self::createMock(RedirectService::class);

        $this->middleware = new SmartLinkMiddleware(
            $this->kernel,
            $this->redirectService,
        );
    }

    public function testRedirect(): void
    {
        $request = Request::create('/redirect');
        $this->redirectService->expects(self::once())
            ->method('getRedirectUrl')
            ->willReturn('https://example.com/breakfast');

        $response = $this->middleware->handle($request);

        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertEquals('https://example.com/breakfast', $response->headers->get('Location'));
    }

    public function testNoRedirect(): void
    {
        $request = Request::create('/redirect');
        $this->redirectService->expects(self::once())
            ->method('getRedirectUrl')
            ->willReturn(null);

        $this->kernel->expects(self::once())
            ->method('handle')
            ->willReturn(new Response('OK'));

        $response = $this->middleware->handle($request);

        self::assertEquals('OK', $response->getContent());
    }
}