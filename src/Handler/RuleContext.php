<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;

class RuleContext
{
    protected ?string $timezone = null;
    protected ?string $restaurantSlug;

    public function __construct(
        private readonly Request $request,
    ) {
        $this->restaurantSlug = $this->request->attributes->get('restaurantSlug');
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): static
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getRestaurantSlug(): ?string
    {
        return $this->restaurantSlug;
    }

    public function setRestaurantSlug(?string $restaurantSlug): static
    {
        $this->restaurantSlug = $restaurantSlug;

        return $this;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}