<?php

namespace App\Entity;

use App\Repository\Trajet\TrajetRepository;
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

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $datePlanification;

    #[ORM\Column(type: 'string', length: 20)]
    private string $type; // Aller, Retour, Aller/Retour

    #[ORM\Column(type: 'integer')]
    private int $nombreTicketsPlanifie;

    #[ORM\Column(type: 'integer')]
    private int $nombreTicketsVendus = 0;

    #[ORM\OneToMany(mappedBy: "trajet", targetEntity: Ticket::class, cascade: ["persist"], orphanRemoval: true)]
    private Collection $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBus(): ?Bus
    {
        return $this->bus;
    }

    public function setBus(?Bus $bus): self
    {
        $this->bus = $bus;
        return $this;
    }

    public function getLigne(): ?Ligne
    {
        return $this->ligne;
    }

    public function setLigne(?Ligne $ligne): self
    {
        $this->ligne = $ligne;
        return $this;
    }

    public function getDatePlanification(): \DateTimeInterface
    {
        return $this->datePlanification;
    }

    public function setDatePlanification(\DateTimeInterface $datePlanification): self
    {
        $this->datePlanification = $datePlanification;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getNombreTicketsPlanifie(): int
    {
        return $this->nombreTicketsPlanifie;
    }

    public function setNombreTicketsPlanifie(int $nombreTicketsPlanifie): self
    {
        $this->nombreTicketsPlanifie = $nombreTicketsPlanifie;
        return $this;
    }

    public function getNombreTicketsVendus(): int
    {
        return $this->nombreTicketsVendus;
    }

    public function setNombreTicketsVendus(int $nombreTicketsVendus): self
    {
        $this->nombreTicketsVendus = $nombreTicketsVendus;
        return $this;
    }

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setTrajet($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            if ($ticket->getTrajet() === $this) {
                $ticket->setTrajet(null);
            }
        }

        return $this;
    }
}
