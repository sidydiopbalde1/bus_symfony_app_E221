<?php
namespace App\Interfaces\Services\Ligne;

use App\Dto\Ligne\CreateLigneRequest;
use App\Entity\Ligne;

interface LigneServiceInterface
{
    public function createLigne(CreateLigneRequest $dto): Ligne;

    public function getLignesWithArretCount(): array;

    public function getLigneWithArrets(int $id): ?Ligne;

    public function updateLigne(int $id, CreateLigneRequest $dto): ?Ligne;

    public function deleteLigne(int $id): bool;
}
