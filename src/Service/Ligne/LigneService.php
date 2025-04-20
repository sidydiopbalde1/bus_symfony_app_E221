<?php
namespace App\Service\Ligne;

use App\Dto\Ligne\CreateLigneRequest;
use App\Entity\Ligne;
use App\Interfaces\Repositories\Ligne\LigneRepositoryInterface;
use App\Interfaces\Services\Ligne\LigneServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class LigneService implements LigneServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private LigneRepositoryInterface $ligneRepository
    ) {}

    public function createLigne(CreateLigneRequest $dto): Ligne
    {
        $ligne = new Ligne();
        $ligne->setNbrKilometre($dto->nbrKilometre);
        $ligne->setTarif($dto->tarif);
        $ligne->setEtat($dto->etat);
        $ligne->setDateCreation(new \DateTime());

        $this->ligneRepository->addLigne($ligne);

        return $ligne;
    }

    public function getLignesWithArretCount(): array
    {
        return $this->ligneRepository->findAllWithArretCount();
    }

    public function getLigneWithArrets(int $id): ?Ligne
    {
        return $this->ligneRepository->findByIdWithArrets($id);
    }

    public function updateLigne(int $id, CreateLigneRequest $dto): ?Ligne
    {
        $ligne = $this->ligneRepository->findLigneById($id);
        if (!$ligne) {
            return null;
        }

        $ligne->setNbrKilometre($dto->nbrKilometre);
        $ligne->setTarif($dto->tarif);
        $ligne->setEtat($dto->etat);
        $this->ligneRepository->updateLigne();

        return $ligne;
    }

    public function deleteLigne(int $id): bool
    {
        $ligne = $this->ligneRepository->findLigneById($id);
        if (!$ligne) {
            return false;
        }

        $this->ligneRepository->removeLigne($ligne);
        return true;
    }
}
