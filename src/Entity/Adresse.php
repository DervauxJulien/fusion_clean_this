<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $N_rue = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom_Rue = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom_Ville = null;

    #[ORM\Column]
    private ?int $CP = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNRue(): ?int
    {
        return $this->N_rue;
    }

    public function setNRue(int $N_rue): static
    {
        $this->N_rue = $N_rue;

        return $this;
    }

    public function getNomRue(): ?string
    {
        return $this->Nom_Rue;
    }

    public function setNomRue(string $Nom_Rue): static
    {
        $this->Nom_Rue = $Nom_Rue;

        return $this;
    }

    public function getNomVille(): ?string
    {
        return $this->Nom_Ville;
    }

    public function setNomVille(string $Nom_Ville): static
    {
        $this->Nom_Ville = $Nom_Ville;

        return $this;
    }

    public function getCP(): ?int
    {
        return $this->CP;
    }

    public function setCP(int $CP): static
    {
        $this->CP = $CP;

        return $this;
    }
    public function __toString()
    {
        return $this->N_rue  . " " . $this->Nom_Rue;  
    }
}
