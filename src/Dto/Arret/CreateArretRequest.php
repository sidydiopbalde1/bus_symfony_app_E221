<?php

namespace App\Dto\Arret;

use Symfony\Component\Validator\Constraints as Assert;

class CreateArretRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    public string $nom;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    public int $numero;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    public int $ligneId;
}
