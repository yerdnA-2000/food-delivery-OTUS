<?php

namespace App\Tests\Unit\Middleware;

use App\Middleware\RequireAuthMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

class RequireAuthMiddlewareTest extends TestCase
{
    private HttpKernelInterface&MockObject $kernel;
    private Security&MockObject $security;
    private RouterInterface&MockObject $router;
    private RequireAuthMiddleware $middleware;

    protected function setUp(): void
    {
        $this->kernel = self::createMock(HttpKernelInterface::class);
        $this->security = self::createMock(Security::class);
        $this->router = self::createMock(RouterInterface::class);

        $this->middleware = new RequireAuthMiddleware(
            $this->kernel,
            $this->security,
            $this->router,
        );
    }

    public function testMiddlewareAllowsAccessForPublicRoute(): void
    {
        $routeCollection = self::createMock(RouteCollection::class);

        // Создаём мок для маршрута, который не требует аутентификации
        $route = self::createMock(Route::class);
        $route->expects(self::once())
            ->method('getDefault')
            ->with('_controller')
            ->willReturn('App\Tests\Unit\Stub\RequiresAuthControllerStub::public');

        $routeCollection->expects(self::once())
            ->method('get')
            ->with('public_route')
            ->willReturn($route);

        $this->router->expects(self::once())
            ->method('getRouteCollection')
            ->willReturn($routeCollection);

        $this->kernel->expects(self::once())
            ->method('handle')
            ->willReturn(new Response('Public content'));

        $request = Request::create('/public-route');
        $request->attributes->set('_route', 'public_route');

        $response = $this->middleware->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Public content', $response->getContent());
    }

    public function testMiddlewareRedirectsUnauthenticatedUser(): void
    {
        $routeCollection = self::createMock(RouteCollection::class);

        // Создаём мок для маршрута, который требует аутентификации
        $route = self::createMock(Route::class);
        $route->expects(self::once())
            ->method('getDefault')
            ->with('_controller')
            ->willReturn('App\Tests\Unit\Stub\RequiresAuthControllerStub::protected');

        $routeCollection->expects(self::once())
            ->method('get')
            ->with('protected_route')
            ->willReturn($route);

        $this->router->expects(self::once())
            ->method('getRouteCollection')
            ->willReturn($routeCollection);

        $this->security->expects(self::once())
            ->method('isGranted')
            ->with('IS_AUTHENTICATED_FULLY')
            ->willReturn(false);

        $this->router->expects(self::once())
            ->method('generate')
            ->with('login')->willReturn('/login');

        $request = Request::create('/protected-route');
        $request->attributes->set('_route', 'protected_route');

        $response = $this->middleware->handle($request);

        self::assertInstanceOf(RedirectResponse::class, $response);
        self::assertEquals(302, $response->getStatusCode());
        self::assertEquals('/login', $response->headers->get('Location'));
    }

    public function testMiddlewareAllowsAuthenticatedUser(): void
    {
        $routeCollection = self::createMock(RouteCollection::class);

        // Создаём мок для маршрута, который требует аутентификации
        $route = self::createMock(Route::class);
        $route->expects(self::once())
            ->method('getDefault')
            ->with('_controller')
            ->willReturn('App\Tests\Unit\Stub\RequiresAuthControllerStub::protected');

        $routeCollection->expects(self::once())
            ->method('get')
            ->with('protected_route')
            ->willReturn($route);

        $this->router->expects(self::once())
            ->method('getRouteCollection')
            ->willReturn($routeCollection);

        $this->security->expects(self::once())
            ->method('isGranted')
            ->with('IS_AUTHENTICATED_FULLY')
            ->willReturn(true);

        $this->kernel->expects(self::once())
            ->method('handle')
            ->willReturn(new Response('Protected content'));

        $request = Request::create('/protected-route');
        $request->attributes->set('_route', 'protected_route');

        $response = $this->middleware->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Protected content', $response->getContent());
    }
}