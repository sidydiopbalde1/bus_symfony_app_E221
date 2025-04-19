<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConducteursRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ConducteursRepository::class)]
class Conducteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $matricule = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(length: 20, unique: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 50)]
    private ?string $typePermis = null;

    #[ORM\OneToMany(mappedBy: "conducteur", targetEntity: Bus::class)]
    private $buses;

    #[ORM\Column]
    private ?bool $disponible = null;

    public function __construct()
    {
        $this->buses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getTypePermis(): ?string
    {
        return $this->typePermis;
    }

    public function setTypePermis(string $typePermis): self
    {
        $this->typePermis = $typePermis;
        return $this;
    }

    public function getBuses()
    {
        return $this->buses;
    }

    public function addBus(Bus $bus): self
    {
        if (!$this->buses->contains($bus)) {
            $this->buses[] = $bus;
            $bus->setConducteur($this);
        }
        return $this;
    }

    public function removeBus(Bus $bus): self
    {
        if ($this->buses->removeElement($bus)) {
            if ($bus->getConducteur() === $this) {
                $bus->setConducteur(null);
            }
        }
        return $this;
    }

    // src/Entity/Conducteur.php

  

    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;

        return $this;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'matricule' => $this->getMatricule(),
            'telephone' => $this->getTelephone(),
            'typePermis' => $this->getTypePermis(),
            'disponible' => $this->isDisponible(),
        ];
    }
}
