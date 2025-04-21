<?php

namespace App\Interfaces\Services\Trajet;

use App\Dto\Trajet\CreateTrajetRequest;
use App\Dto\Trajet\ValiderTrajetRequest;
use App\Entity\Trajet;

interface TrajetServiceInterface
{
    public function planifierTrajet(CreateTrajetRequest $dto): Trajet;

    public function listerTrajets(): array;

    public function validerTrajet(int $trajetId, ValiderTrajetRequest $dto): ?Trajet;
}
