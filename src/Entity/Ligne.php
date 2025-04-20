<?php

namespace App\Entity;

use App\Repository\Ligne\LigneRepository;
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

    #[ORM\OneToMany(mappedBy: "ligne", targetEntity: Arret::class, cascade: ["persist", "remove"])]
    private Collection $arrets;

    #[ORM\OneToMany(mappedBy: "ligne", targetEntity: Trajet::class, cascade: ["persist", "remove"])]
    private Collection $trajets; // ✅ ajout de la relation inverse de Trajet

    public function __construct()
    {
        $this->arrets = new ArrayCollection();
        $this->trajets = new ArrayCollection();
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

    public function getTarif(): string
    {
        return $this->tarif;
    }

    public function setTarif(string $tarif): self
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

    public function addArret(Arret $arret): self
    {
        if (!$this->arrets->contains($arret)) {
            $this->arrets[] = $arret;
            $arret->setLigne($this);
        }

        return $this;
    }

    public function removeArret(Arret $arret): self
    {
        if ($this->arrets->removeElement($arret)) {
            if ($arret->getLigne() === $this) {
                $arret->setLigne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trajet>
     */
    public function getTrajets(): Collection
    {
        return $this->trajets;
    }

    public function addTrajet(Trajet $trajet): self
    {
        if (!$this->trajets->contains($trajet)) {
            $this->trajets[] = $trajet;
            $trajet->setLigne($this);
        }

        return $this;
    }

    public function removeTrajet(Trajet $trajet): self
    {
        if ($this->trajets->removeElement($trajet)) {
            if ($trajet->getLigne() === $this) {
                $trajet->setLigne(null);
            }
        }

        return $this;
    }
}
