<?php

namespace App\Controller;

use App\Dto\Ligne\CreateLigneRequest;
use App\Interfaces\Services\Ligne\LigneServiceInterface;
use App\Service\Validator\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lignes')]
final class LignesController extends AbstractController
{
    public function __construct(
        private LigneServiceInterface $ligneService,
        private RequestValidator $requestValidator,
    ) {}
 
    #[Route('', name: 'get_lignes', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $lignes = $this->ligneService->getLignesWithArretCount();

        $data = array_map(function ($item) {
            $ligne = $item[0];
            return [
                'id' => $ligne->getId(),
                'nbrKilometre' => $ligne->getNbrKilometre(),
                'tarif' => $ligne->getTarif(),
                'etat' => $ligne->getEtat(),
                'dateCreation' => $ligne->getDateCreation()->format('Y-m-d H:i:s'),
                'nombreArrets' => (int) $item['arretCount'],
            ];
        }, $lignes);

        return $this->json($data);
    }

    #[Route('', name: 'create_ligne', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        /** @var CreateLigneRequest $dto */
        $dto = $this->requestValidator->validate($request->getContent(), CreateLigneRequest::class);

        $ligne = $this->ligneService->createLigne($dto);

        return $this->json([
            'id' => $ligne->getId(),
            'message' => 'Ligne créée avec succès'
        ], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'update_ligne', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        /** @var CreateLigneRequest $dto */
        $dto = $this->requestValidator->validate($request->getContent(), CreateLigneRequest::class);

        $ligne = $this->ligneService->updateLigne($id, $dto);

        if (!$ligne) {
            return $this->json(['message' => 'Ligne non trouvée'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $ligne->getId(),
            'message' => 'Ligne mise à jour avec succès'
        ]);
    }

    #[Route('/{id}', name: 'delete_ligne', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $success = $this->ligneService->deleteLigne($id);

        if (!$success) {
            return $this->json(['message' => 'Ligne non trouvée'], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['message' => 'Ligne supprimée avec succès'], Response::HTTP_OK);
    }
}
