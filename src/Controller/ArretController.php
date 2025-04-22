<?php

namespace App\Controller;

use App\Dto\Arret\CreateArretRequest;
use App\Interfaces\Services\Arret\ArretServiceInterface;
//use App\Service\RequestValidator as ServiceRequestValidator;
use App\Service\Validator\RequestValidator   as ServiceRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/arrets')]
class ArretController extends AbstractController
{
    public function __construct(
        private ArretServiceInterface $arretService,
        private ServiceRequestValidator $requestValidator
    ) {}

    #[Route('', name: 'create_arret', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $dto = $this->requestValidator->validate($request->getContent(), CreateArretRequest::class);
        $arret = $this->arretService->create($dto);

        return $this->json([
            'id' => $arret->getId(),
            'message' => 'Arrêt créé avec succès'
        ], Response::HTTP_CREATED);
    }

    #[Route('/ligne/{id}', name: 'get_arrets_by_ligne', methods: ['GET'])]
    public function getByLigne(int $id): JsonResponse
    {
        $arrets = $this->arretService->getByLigne($id);

        $data = array_map(function ($a) {
            return [
                'id' => $a->getId(),
                'nom' => $a->getNom(),
                'numero' => $a->getNumero(),
                'ligneId' => $a->getLigne()->getId()
            ];
        }, $arrets);

        return $this->json($data);
    }
}
