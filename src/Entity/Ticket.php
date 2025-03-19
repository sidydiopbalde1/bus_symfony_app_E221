<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?Trajet $trajet = null;

    #[ORM\Column]
    private ?int $quantiteVendue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }

    public function setTrajet(?Trajet $trajet): static
    {
        $this->trajet = $trajet;

        return $this;
    }

    public function getQuantiteVendue(): ?int
    {
        return $this->quantiteVendue;
    }

    public function setQuantiteVendue(int $quantiteVendue): static
    {
        $this->quantiteVendue = $quantiteVendue;

        return $this;
    }
}
