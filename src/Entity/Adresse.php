<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $n_rue = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_rue = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_ville = null;

    #[ORM\Column]
    private ?int $cp = null;

    /**
     * @var Collection<int, Operation>
     */
    #[ORM\OneToMany(targetEntity: Operation::class, mappedBy: 'adresse')]
    private Collection $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNRue(): ?int
    {
        return $this->n_rue;
    }

    public function setNRue(int $n_rue): static
    {
        $this->n_rue = $n_rue;

        return $this;
    }

    public function getNomRue(): ?string
    {
        return $this->nom_rue;
    }

    public function setNomRue(string $nom_rue): static
    {
        $this->nom_rue = $nom_rue;

        return $this;
    }

    public function getNomVille(): ?string
    {
        return $this->nom_ville;
    }

    public function setNomVille(string $nom_ville): static
    {
        $this->nom_ville = $nom_ville;

        return $this;
    }

    public function getcp(): ?int
    {
        return $this->cp;
    }

    public function setcp(int $cp): static
    {
        $this->cp = $cp;

        return $this;
    }
    public function __toString()
    {
        return $this->n_rue  . " " . $this->nom_rue;  
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): static
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
            $operation->setAdresse($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getAdresse() === $this) {
                $operation->setAdresse(null);
            }
        }

        return $this;
    }
}
