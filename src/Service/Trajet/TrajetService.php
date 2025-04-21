<?php

namespace App\Service\Trajet;

use App\Dto\Trajet\CreateTrajetRequest;
use App\Entity\Ticket;
use App\Entity\Trajet;
use App\Interfaces\Repositories\Trajet\TrajetRepositoryInterface;
use App\Interfaces\Services\Trajet\TrajetServiceInterface;
use App\Repository\BusRepository;
use App\Repository\Ligne\LigneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TrajetService implements TrajetServiceInterface
{
    public function __construct(
        private TrajetRepositoryInterface $trajetRepository,
        private BusRepository $busRepository,
        private LigneRepository $ligneRepository,
        private EntityManagerInterface $em
    ) {}

    public function planifierTrajet(CreateTrajetRequest $dto): Trajet
    {
        $bus = $this->busRepository->find($dto->busId);
        $ligne = $this->ligneRepository->find($dto->ligneId);

        if (!$bus || !$ligne) {
            throw new BadRequestHttpException("Bus ou ligne introuvable.");
        }

        if (!$bus->isEnCirculation()) {
            throw new BadRequestHttpException("Le bus n'est pas en circulation.");
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $dto->datePlanification);
        if (!$date) {
            throw new BadRequestHttpException("Date invalide.");
        }

        if ($this->trajetRepository->hasTrajetForBusAtDate($bus->getId(), $date)) {
            throw new BadRequestHttpException("Ce bus a déjà un trajet ce jour.");
        }

        $trajet = new Trajet();
        $trajet->setBus($bus);
        $trajet->setLigne($ligne);
        $trajet->setDatePlanification($date);
        $trajet->setType($dto->type);
        $trajet->setNombreTicketsPlanifie($dto->nombreTickets);
        $trajet->setNombreTicketsVendus(0);

        // Création des tickets
        for ($i = 0; $i < $dto->nombreTickets; $i++) {
            $ticket = new Ticket();
            $ticket->setPrix((string) $ligne->getTarif());
            $ticket->setEtat('Disponible');
            $ticket->setDateVente(new \DateTime());
            $ticket->setTrajet($trajet);
            $trajet->addTicket($ticket);
        }

        $this->trajetRepository->save($trajet);

        return $trajet;
    }

    public function listerTrajets(): array
    {
        return $this->trajetRepository->findAll();
    }
}

