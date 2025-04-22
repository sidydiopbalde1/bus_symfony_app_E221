<?php

namespace App\Entity;

use App\Repository\Ligne\LigneRepository as LigneLigneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneLigneRepository::class)]
class Ligne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "integer")]
    private int $nbrKilometre;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $tarif;

    #[ORM\Column(type: "string", length: 50)]
    private string $etat;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateCreation;
    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Station $stationDepart = null;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Station $stationArrivee = null;

    #[ORM\ManyToMany(targetEntity: Arret::class, inversedBy: "lignes")]
    #[ORM\JoinTable(name: "ligne_arret")]
    private Collection $arrets;
    

    public function __construct()
    {
        $this->arrets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrKilometre(): int
    {
        return $this->nbrKilometre;
    }

    public function setNbrKilometre(int $nbrKilometre): self
    {
        $this->nbrKilometre = $nbrKilometre;
        return $this;
    }

    public function getTarif(): float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;
        return $this;
    }

    public function getEtat(): string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;
        return $this;
    }

    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return Collection<int, Arret>
     */
    public function getArrets(): Collection
    {
        return $this->arrets;
    }
 
    public function getStationDepart(): ?Station { return $this->stationDepart; }

    public function setStationDepart(?Station $station): self { $this->stationDepart = $station; return $this; }
    public function getStationArrivee(): ?Station { return $this->stationArrivee; }

    public function setStationArrivee(?Station $station): self { $this->stationArrivee = $station; return $this; }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nbrKilometre' => $this->getNbrKilometre(),
            'tarif' => $this->getTarif(),
            'etat' => $this->getEtat(),
            'dateCreation' => $this->getDateCreation()->format('Y-m-d'),
            'stationDepart' => $this->stationDepart?->toArray(),
            'stationArrivee' => $this->stationArrivee?->toArray(),
            'arrets' => array_map(fn($a) => $a->toArray(), $this->arrets->toArray()),
        ];
    }

    public function addArret(Arret $arret): self
    {
        if (!$this->arrets->contains($arret)) {
            $this->arrets[] = $arret;
            $arret->getLignes()->add($this);
        }
    
        return $this;
    }
    
    public function removeArret(Arret $arret): self
    {
        if ($this->arrets->contains($arret)) {
            $this->arrets->removeElement($arret);
            $arret->getLignes()->removeElement($this);
        }
    
        return $this;
    }
    
}
