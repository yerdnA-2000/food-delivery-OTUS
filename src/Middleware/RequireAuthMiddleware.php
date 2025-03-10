<?php

namespace App\Middleware;

use App\Attribute\RequiresAuth;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class RequireAuthMiddleware implements HttpKernelInterface
{
    public function __construct(
        private readonly HttpKernelInterface $kernel,
        private readonly Security $security,
        private readonly RouterInterface $router,
    ) {
    }

    public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
    {
        $routeName = $request->attributes->get('_route');
        $route = $this->router->getRouteCollection()->get($routeName);

        if ($route && $this->isAuthRequired($route) && !$this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $loginUrl = $this->router->generate('login');

            return new RedirectResponse($loginUrl);
        }

        return $this->kernel->handle($request, $type, $catch);
    }

    private function isAuthRequired(Route $route): bool
    {
        if (!$controller = $route->getDefault('_controller')) {
            return false;
        }

        if (str_contains($controller, '::')) {
            [$controllerClass, $methodName] = explode('::', $controller);
        } else {
            $controllerClass = $controller;
            $methodName = '__invoke';
        }

        $reflectionClass = new \ReflectionClass($controllerClass);

        if ($reflectionClass->hasMethod($methodName)) {
            $reflectionMethod = $reflectionClass->getMethod($methodName);

            if (!empty($reflectionMethod->getAttributes(RequiresAuth::class))) {
                return true;
            }
        }

        return !empty($reflectionClass->getAttributes(RequiresAuth::class));
    }
}