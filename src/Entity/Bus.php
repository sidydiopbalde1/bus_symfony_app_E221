<?php

namespace App\Entity;

use App\Enum\BusType;
use App\Repository\BusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusRepository::class)]
class Bus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $immatriculation = null;

    #[ORM\Column(type: 'string', enumType: BusType::class)]
    private BusType $type;

    #[ORM\Column(type: "integer")]
    private int $kilometrage;

    #[ORM\Column(type: "integer")]
    private int $nbrePlaces;
    
    #[ORM\Column(type: "boolean")]
    private bool $enCirculation;

    #[ORM\OneToMany(mappedBy: "bus", targetEntity: Trajet::class)]
    private Collection $trajets;

    #[ORM\ManyToOne(targetEntity: Conducteur::class, inversedBy: "buses")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Conducteur $conducteur = null;

    /**
     * @var Collection<int, Panne>
     */
    #[ORM\OneToMany(targetEntity: Panne::class, mappedBy: 'bus')]
    private Collection $pannes;

    // // #[ORM\OneToMany(mappedBy: "bus", targetEntity: Panne::class)]
    // private Collection $pannes;

    public function __construct()
    {
        $this->trajets = new ArrayCollection();
        // $this->pannes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;
        return $this;
    }

    public function getType(): BusType
    {
        return $this->type;
    }

    public function setType(BusType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getKilometrage(): int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;
        return $this;
    }

    public function getNbrePlaces(): int
    {
        return $this->nbrePlaces;
    }

    public function setNbrePlaces(int $nbrePlaces): self
    {
        $this->nbrePlaces = $nbrePlaces;
        return $this;
    }

    public function isEnCirculation(): bool
    {
        return $this->enCirculation;
    }

    public function setEnCirculation(bool $enCirculation): self
    {
        $this->enCirculation = $enCirculation;
        return $this;
    }

    public function getTrajets(): Collection
    {
        return $this->trajets;
    }
    public function getConducteur(): ?Conducteur
    {
        return $this->conducteur;
    }

    public function setConducteur(?Conducteur $conducteur): self
    {
        $this->conducteur = $conducteur;
        return $this;
    }

    /**
     * @return Collection<int, Panne>
     */
    public function getPannes(): Collection
    {
        return $this->pannes;
    }

    public function addPanne(Panne $panne): static
    {
        if (!$this->pannes->contains($panne)) {
            $this->pannes->add($panne);
            $panne->setBus($this);
        }

        return $this;
    }

    public function removePanne(Panne $panne): static
    {
        if ($this->pannes->removeElement($panne)) {
            // set the owning side to null (unless already changed)
            if ($panne->getBus() === $this) {
                $panne->setBus(null);
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'immatriculation' => $this->getImmatriculation(),
            'type' => $this->getType(),
            'nbrePlaces' => $this->getNbrePlaces(),
            'kilométrage' => $this->getKilometrage(),
            'enCirculation' => $this->isEnCirculation(),];
    }
}
