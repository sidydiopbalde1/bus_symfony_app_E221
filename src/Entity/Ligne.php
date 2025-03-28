<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneRepository;

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

    // #[ORM\OneToMany(mappedBy: "ligne", targetEntity: Arret::class, cascade: ["persist", "remove"])]
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
