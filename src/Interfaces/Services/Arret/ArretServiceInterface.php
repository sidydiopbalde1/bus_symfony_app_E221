<?php

namespace App\Interfaces\Services\Arret;

use App\Dto\Arret\CreateArretRequest;
use App\Entity\Arret;

interface ArretServiceInterface
{
    public function create(CreateArretRequest $dto): Arret;

    public function getByLigne(int $ligneId): array;
}
