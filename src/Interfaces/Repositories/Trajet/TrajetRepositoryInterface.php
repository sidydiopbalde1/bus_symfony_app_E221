<?php

namespace App\Interfaces\Repositories\Trajet;

use App\Entity\Trajet;

interface TrajetRepositoryInterface
{
    public function save(Trajet $trajet): void;

    public function findAll(): array;

    /**
     * Vérifie si un bus a déjà un trajet planifié à une date donnée.
     */
    public function hasTrajetForBusAtDate(int $busId, \DateTimeInterface $date): bool;
    
    public function findLigneById(int $id): ?Trajet;

}
