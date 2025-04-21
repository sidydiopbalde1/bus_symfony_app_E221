<?php

namespace App\Entity;

use App\Repository\ArretRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArretRepository::class)]
class Arret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "integer")]
    private int $numero;

    #[ORM\Column(length: 255)]
    private string $nom;

    #[ORM\ManyToMany(targetEntity: Ligne::class, mappedBy: "arrets")]
    private Collection $lignes;

    public function __construct()
    {
        $this->lignes = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): string { return $this->nom; }

    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getNumero(): int { return $this->numero; }

    public function setNumero(int $numero): self { $this->numero = $numero; return $this; }

    public function getLignes(): Collection { return $this->lignes; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'nom' => $this->nom,
        ];
    }
}

