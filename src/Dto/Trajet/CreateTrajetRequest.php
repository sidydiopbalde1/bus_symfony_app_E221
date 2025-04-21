<?php
namespace App\Dto\Trajet;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTrajetRequest
{
    #[Assert\NotBlank(message: "L'ID du bus est obligatoire.")]
    #[Assert\Type(type: 'integer', message: "L'ID du bus doit être un entier.")]
    public int $busId;

    #[Assert\NotBlank(message: "L'ID de la ligne est obligatoire.")]
    #[Assert\Type(type: 'integer', message: "L'ID de la ligne doit être un entier.")]
    public int $ligneId;

    #[Assert\NotBlank(message: "La date de planification est obligatoire.")]
    #[Assert\DateTime(format: 'Y-m-d H:i:s', message: "Le format de la date doit être 'Y-m-d H:i:s'.")]
    public string $datePlanification;

    #[Assert\NotBlank(message: "Le type de trajet est obligatoire.")]
    #[Assert\Choice(choices: ['Aller', 'Retour', 'Aller/Retour'], message: "Le type doit être 'Aller', 'Retour' ou 'Aller/Retour'.")]
    public string $type;

    #[Assert\NotBlank(message: "Le nombre de tickets est obligatoire.")]
    #[Assert\Type(type: 'integer', message: "Le nombre de tickets doit être un entier.")]
    #[Assert\Positive(message: "Le nombre de tickets doit être supérieur à 0.")]
    public int $nombreTickets;
}
