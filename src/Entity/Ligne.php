<?php
namespace App\Entity;

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
    private string $tarif; // ✅ corrigé en string

    #[ORM\Column(type: "string", length: 50)]
    private string $etat;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateCreation;

    // #[ORM\OneToMany(mappedBy: "ligne", targetEntity: Arret::class, cascade: ["persist", "remove"])]
    private Collection $arrets;

    public function __construct()
    {
        $this->arrets = new ArrayCollection();
        $this->trajets = new ArrayCollection();
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

    public function getTarif(): float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
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
        return $this->arrets;
    }

    // public function addArret(Arret $arret): self
    // {
    //     if (!$this->arrets->contains($arret)) {
    //         $this->arrets[] = $arret;
    //         $arret->setLigne($this);
    //     }
    //     return $this;
    // }

    // public function removeArret(Arret $arret): self
    // {
    //     if ($this->arrets->removeElement($arret)) {
    //         if ($arret->getLigne() === $this) {
    //             $arret->setLigne(null);
    //         }
    //     }
    //     return $this;
    // }
}
