<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrajetRepository::class)]
class Trajet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Bus::class, inversedBy: "trajets")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bus $bus = null;

    #[ORM\ManyToOne(targetEntity: Ligne::class, inversedBy: "trajets")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ligne $ligne = null;

    #[ORM\OneToMany(mappedBy: "trajet", targetEntity: Ticket::class)]
    private Collection $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getBus(): ?Bus { return $this->bus; }

    public function setBus(?Bus $bus): self {
        $this->bus = $bus;
        return $this;
    }

    public function getLigne(): ?Ligne { return $this->ligne; }

    public function setLigne(?Ligne $ligne): self {
        $this->ligne = $ligne;
        return $this;
    }

    public function getTickets(): Collection { return $this->tickets; }
}
