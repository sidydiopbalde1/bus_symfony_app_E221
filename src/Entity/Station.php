<?php
namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "integer")]
    private int $numero;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "string", length: 255)]
    private string $adresse;

    public function getId(): ?int { return $this->id; }

    public function getNumero(): int { return $this->numero; }

    public function setNumero(int $numero): self { $this->numero = $numero; return $this; }

    public function getNom(): string { return $this->nom; }

    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getAdresse(): string { return $this->adresse; }

    public function setAdresse(string $adresse): self { $this->adresse = $adresse; return $this; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'nom' => $this->nom,
            'adresse' => $this->adresse,
        ];
    }
}
