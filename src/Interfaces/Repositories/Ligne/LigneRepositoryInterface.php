<?php

namespace App\Interfaces\Repositories\Ligne;

use App\Entity\Ligne;

interface LigneRepositoryInterface
{
    public function findAllWithArretCount(): array;
    public function findLigneById(int $id): ?Ligne;

    public function findByIdWithArretCount(int $id): ?array;

    public function findByIdWithArrets(int $id): ?Ligne;

    public function addLigne(Ligne $ligne): void;

    public function removeLigne(Ligne $ligne): void;

    public function updateLigne(): void;
}
