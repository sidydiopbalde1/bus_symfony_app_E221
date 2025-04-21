<?php
namespace App\Dto\Ligne;

use Symfony\Component\Validator\Constraints as Assert;

class CreateLigneRequest
{
    #[Assert\NotBlank(message: "Le nombre de kilomètres est obligatoire.")]
    #[Assert\Type(type: 'integer', message: "Le nombre de kilomètres doit être un entier.")]
    #[Assert\Positive(message: "Le nombre de kilomètres doit être positif.")]
    public int $nbrKilometre;

    #[Assert\NotBlank(message: "Le tarif est obligatoire.")]
    #[Assert\Type(type: 'float', message: "Le tarif doit être un nombre décimal.")]
    #[Assert\PositiveOrZero(message: "Le tarif ne peut pas être négatif.")]
    public float $tarif;

    #[Assert\NotBlank(message: "L'état est obligatoire.")]
    #[Assert\Type(type: 'string', message: "L'état doit être une chaîne de caractères.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "L'état ne doit pas dépasser {{ limit }} caractères."
    )]
    public string $etat;
}
