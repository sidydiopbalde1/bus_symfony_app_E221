<?php

namespace App\Controller;

use App\Dto\Trajet\CreateTrajetRequest;
use App\Entity\Trajet;
use App\Interfaces\Services\Trajet\TrajetServiceInterface;
use App\Service\Validator\RequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Dto\Trajet\ValiderTrajetRequest;


#[Route('/trajets')]
class TrajetController extends AbstractController
{
    public function __construct(
        private TrajetServiceInterface $trajetService,
        private RequestValidator $requestValidator
    ) {}

    #[Route('', name: 'planifier_trajet', methods: ['POST'])]
    public function planifier(Request $request): JsonResponse
    {
        /** @var CreateTrajetRequest $dto */
        $dto = $this->requestValidator->validate($request->getContent(), CreateTrajetRequest::class);

        $trajet = $this->trajetService->planifierTrajet($dto);

        return $this->json([
            'message' => 'Trajet planifié avec succès',
            'id' => $trajet->getId()
        ], Response::HTTP_CREATED);
    }

    #[Route('', name: 'lister_trajets', methods: ['GET'])]
    public function lister(): JsonResponse
    {
        $trajets = $this->trajetService->listerTrajets();

        $data = array_map(fn(Trajet $t) => [
            'id' => $t->getId(),
            'bus' => $t->getBus()?->toArray(),
            'ligne' => $t->getLigne()?->toArray(),
            'date' => $t->getDatePlanification()->format('Y-m-d H:i:s'),
            'type' => $t->getType(),
            'ticketsPlanifies' => $t->getNombreTicketsPlanifie(),
            'ticketsVendus' => $t->getNombreTicketsVendus(),
        ], $trajets);

        return $this->json($data);
    }
    #[Route('/{id}/valider', name: 'valider_trajet', methods: ['PUT'])]
public function valider(int $id, Request $request): JsonResponse
{
    /** @var ValiderTrajetRequest $dto */
    $dto = $this->requestValidator->validate($request->getContent(), ValiderTrajetRequest::class);

    $trajet = $this->trajetService->validerTrajet($id, $dto);

    if (!$trajet) {
        return $this->json(['message' => 'Trajet introuvable.'], Response::HTTP_NOT_FOUND);
    }

    return $this->json([
        'message' => 'Trajet validé avec succès.',
        'id' => $trajet->getId(),
        'ticketsVendus' => $trajet->getNombreTicketsVendus(),
        'dateValidation' => $trajet->getDateValidation()?->format('Y-m-d H:i:s'),
    ]);
}
}
