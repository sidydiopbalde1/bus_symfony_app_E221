<?php

namespace App\Interfaces\Services\Trajet;

use App\Dto\Trajet\CreateTrajetRequest;
use App\Entity\Trajet;

interface TrajetServiceInterface
{
    /**
     * Planifie un trajet (si le bus est en circulation et disponible).
     */
    public function planifierTrajet(CreateTrajetRequest $dto): Trajet;

    /**
     * Liste tous les trajets planifiés.
     */
    public function listerTrajets(): array;
}
