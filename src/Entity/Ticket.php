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

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private string $prix; // ✅ corrigé en string

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateVente;

    #[ORM\Column(length: 50)]
    private string $etat;

    #[ORM\ManyToOne(targetEntity: Trajet::class, inversedBy: "tickets")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trajet $trajet = null;

    public function getId(): ?int { return $this->id; }

    public function getPrix(): string { return $this->prix; }

    public function setPrix(string $prix): self {
        $this->prix = $prix;
        return $this;
    }

    public function getDateVente(): \DateTimeInterface { return $this->dateVente; }

    public function setDateVente(\DateTimeInterface $dateVente): self {
        $this->dateVente = $dateVente;
        return $this;
    }

    public function getEtat(): string { return $this->etat; }

    public function setEtat(string $etat): self {
        $this->etat = $etat;
        return $this;
    }

    public function getTrajet(): ?Trajet { return $this->trajet; }

    public function setTrajet(?Trajet $trajet): self {
        $this->trajet = $trajet;
        return $this;
    }
}
