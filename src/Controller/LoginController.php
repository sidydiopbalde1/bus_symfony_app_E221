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
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST', 'OPTIONS'])]
public function login(Request $request, JWTTokenManagerInterface $jwtManager, UserRepository $userRepository): Response
{
    // CORS Preflight Handling
    if ($request->getMethod() === 'OPTIONS') {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        return $response;
    }

    // Existing login logic
    $data = json_decode($request->getContent(), true);

    if (!isset($data['email']) || !isset($data['password'])) {
        return new JsonResponse(['message' => 'Email et password sont obligatoires'], JsonResponse::HTTP_BAD_REQUEST);
    }

    $user = $userRepository->findOneByEmail($data['email']);

    if (!$user || !password_verify($data['password'], $user->getPassword())) {
        return new JsonResponse(['message' => 'Credentials invalides'], JsonResponse::HTTP_UNAUTHORIZED);
    }

    $token = $jwtManager->create($user);

    $response = new JsonResponse([
        'message' => "Authentification réussie !!",
        'user' => [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ],
        'token' => $token,
    ]);

    // Explicit CORS headers
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'POST');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

    return $response;
}
}
