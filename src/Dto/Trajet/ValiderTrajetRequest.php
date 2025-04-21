<?php

namespace App\Dto\Trajet;

use Symfony\Component\Validator\Constraints as Assert;

class ValiderTrajetRequest
{
    #[Assert\NotBlank(message: "Le nombre de tickets vendus est requis.")]
    #[Assert\Type(type: 'integer')]
    #[Assert\PositiveOrZero(message: "Le nombre de tickets vendus ne peut pas être négatif.")]
    public int $nombreTicketsVendus;

    #[Assert\NotBlank(message: "La date de validation est requise.")]
    #[Assert\DateTime(format: 'Y-m-d H:i:s', message: "Format attendu : Y-m-d H:i:s")]
    public string $dateValidation;
}
