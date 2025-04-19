<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use App\Repository\UserRepository;

class ApiAuthenticator extends AbstractAuthenticator
{
    private JWTEncoderInterface $jwtEncoder;
    private UserRepository $userRepository;

    public function __construct(JWTEncoderInterface $jwtEncoder, UserRepository $userRepository)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        $authorizationHeader = $request->headers->get('Authorization');

        if (!$authorizationHeader || !preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            throw new CustomUserMessageAuthenticationException('Token JWT non fourni ou mal formaté.');
        }

        $jwtToken = $matches[1];

        try {
            $payload = $this->jwtEncoder->decode($jwtToken);
        } catch (\Exception $e) {
            throw new CustomUserMessageAuthenticationException('Token JWT invalide.');
        }

        if (!isset($payload['username'])) {
            throw new CustomUserMessageAuthenticationException('Token JWT invalide, aucun utilisateur trouvé.');
        }

        $user = $this->userRepository->findOneBy(['email' => $payload['username']]);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Utilisateur non trouvé.');
        }

        return new SelfValidatingPassport(new UserBadge($user->getUserIdentifier()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response(json_encode(['message' => 'Échec de l\'authentification: ' . $exception->getMessage()]), Response::HTTP_UNAUTHORIZED, ['Content-Type' => 'application/json']);
    }
}
