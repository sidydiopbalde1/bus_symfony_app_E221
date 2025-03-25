<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\TrajetRepository;

#[ORM\Entity(repositoryClass: TrajetRepository::class)]
class Trajet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $type;

    #[ORM\Column(type: "integer")]
    private int $nbrTicket;

    #[ORM\OneToMany(mappedBy: "trajet", targetEntity: Ticket::class, cascade: ["persist", "remove"])]
    private Collection $tickets;

    #[ORM\ManyToOne(targetEntity: Ligne::class, inversedBy: "trajets")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ligne $ligne = null;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNbrTicket(): int
    {
        return $this->nbrTicket;
    }

    public function setNbrTicket(int $nbrTicket): self
    {
        $this->nbrTicket = $nbrTicket;
        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
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

    public function getLigne(): ?Ligne
    {
        return $this->ligne;
    }

    public function setLigne(?Ligne $ligne): self
    {
        $this->ligne = $ligne;
        return $this;
    }
}
