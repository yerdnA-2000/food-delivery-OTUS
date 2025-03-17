<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class RestaurantController
{
    #[Route('/restaurant/{restaurantSlug}', name: 'restaurant_view', defaults: ['restaurantSlug' => null])]
    public function viewAction(): JsonResponse
    {
        return new JsonResponse([
            'data' => [/* some data */],
        ], 200);
    }
}