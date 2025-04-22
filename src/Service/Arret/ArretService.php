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
        // On récupère toutes les lignes à associer à cet arrêt.
        $lignes = $this->ligneRepository->findById($dto->ligneId); // Suppose que $dto->ligneIds est un tableau d'IDs
    
        if (empty($lignes)) {
            throw new \InvalidArgumentException("Lignes non trouvées.");
        }
    
        $arret = new Arret();
        $arret->setNom($dto->nom);
        $arret->setNumero($dto->numero);
    
        // Associer cet arrêt à toutes les lignes
        foreach ($lignes as $ligne) {
            $arret->addLigne($ligne);
        }
    
        $this->arretRepository->add($arret);
    
        return $arret;
    }
    

    public function getByLigne(int $ligneId): array
    {
        return $this->arretRepository->findByLigneId($ligneId);
    }
}
