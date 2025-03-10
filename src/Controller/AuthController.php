<?php

namespace App\Controller;

use App\Attribute\RequiresAuth;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AuthController extends AbstractController
{
    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    #[RequiresAuth]
    public function meAction(#[CurrentUser] User $user): JsonResponse
    {
        return $this->json([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
}