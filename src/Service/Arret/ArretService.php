<?php

namespace App\Service\Arret;

use App\Dto\Arret\CreateArretRequest;
use App\Entity\Arret;
use App\Interfaces\Repositories\Arret\ArretRepositoryInterface;
use App\Interfaces\Services\Arret\ArretServiceInterface;
use App\Repository\Ligne\LigneRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArretService implements ArretServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ArretRepositoryInterface $arretRepository,
        private LigneRepository $ligneRepository
    ) {}

    public function create(CreateArretRequest $dto): Arret
    {
        $ligne = $this->ligneRepository->find($dto->ligneId);

        if (!$ligne) {
            throw new \InvalidArgumentException("Ligne non trouvée.");
        }

        $arret = new Arret();
        $arret->setNom($dto->nom);
        $arret->setNumero($dto->numero);
        $arret->setLigne($ligne);

        $this->arretRepository->add($arret);

        return $arret;
    }

    public function getByLigne(int $ligneId): array
    {
        return $this->arretRepository->findByLigneId($ligneId);
    }
}
