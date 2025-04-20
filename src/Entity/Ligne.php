<?php
namespace App\Entity;

use App\Repository\LigneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneRepository::class)]
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

    #[ORM\ManyToMany(targetEntity: Arret::class, inversedBy: "lignes", cascade: ["persist"])]
    private Collection $arrets;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Station $stationDepart = null;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Station $stationArrivee = null;

    public function __construct()
    {
        $this->arrets = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNbrKilometre(): int { return $this->nbrKilometre; }

    public function setNbrKilometre(int $nbr): self { $this->nbrKilometre = $nbr; return $this; }

    public function getTarif(): float { return $this->tarif; }

    public function setTarif(float $tarif): self { $this->tarif = $tarif; return $this; }

    public function getEtat(): string { return $this->etat; }

    public function setEtat(string $etat): self { $this->etat = $etat; return $this; }

    public function getDateCreation(): \DateTimeInterface { return $this->dateCreation; }

    public function setDateCreation(\DateTimeInterface $date): self { $this->dateCreation = $date; return $this; }

    public function getArrets(): Collection { return $this->arrets; }

    public function addArret(Arret $arret): self
    {
        if (!$this->arrets->contains($arret)) {
            $this->arrets[] = $arret;
        }
        return $this;
    }

    public function removeArret(Arret $arret): self
    {
        $this->arrets->removeElement($arret);
        return $this;
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
}
