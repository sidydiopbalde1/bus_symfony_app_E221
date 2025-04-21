<?php

namespace App\Interfaces\Repositories\Arret;

use App\Entity\Arret;

interface ArretRepositoryInterface
{
    public function add(Arret $arret): void;

    public function findByLigneId(int $ligneId): array;
}
