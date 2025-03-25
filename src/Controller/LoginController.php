<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, JWTTokenManagerInterface $jwtManager, UserRepository $userRepository): JsonResponse
    {
        // Récupérer les données d'identification (email, password) de la requête
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email']) || !isset($data['password'])) {
            return new JsonResponse(['message' => 'Email and password are required'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Authentifier l'utilisateur
        $user = $userRepository->findOneByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user->getPassword())) {
            return new JsonResponse(['message' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Générer un JWT Token pour l'utilisateur authentifié
        $token = $jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}
