<?php

namespace App\Entity;

use App\Enum\BusType;
use App\Repository\BusRepository;
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

    
    /** @ORM\Column(type="integer") */
    private int $kilometrage;
        
    /** @ORM\Column(type="integer") */
    private int $nbrePlaces;
    
    /** @ORM\Column(type="boolean") */
    private bool $enCirculation;

    /** @ORM\Column(type="string", enumType=TypePermis::class) */
    private string $typePermis;
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
}
