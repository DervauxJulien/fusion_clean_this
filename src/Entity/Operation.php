<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description_Op = null;

    #[ORM\Column(length: 255)]
    private ?string $Statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creation; 
    // = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut ;
    // = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin ;
    // = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adresse $adresse = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

        /**
     * @var Collection<int, Facture>
     */

    #[ORM\OneToOne(targetEntity: Facture::class, mappedBy: "operation")]
    private Facture $Facture;
    
    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'operation')]
    private Collection $User;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description_client = null;

    #[ORM\Column(length: 255)]
    private ?string $Img = null;

    #[ORM\Column]
    private ?bool $Validation_demande = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    public function __construct()
    {
        // $this->Facture = new ArrayCollection();
        $this->User = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionOp(): ?string
    {
        return $this->description_Op;
    }

    public function setDescriptionOp(string $description_Op): static
    {
        $this->description_Op = $description_Op;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }


    /**
     * @return Collection<int, Facture>
     */
    public function getFacture(): Collection
    {
        return $this->Facture;
    }

    public function addFacture(Facture $facture): static
    {
        if (!$this->Facture->contains($facture)) {
            $this->Facture->add($facture);
            $facture->setOperation($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): static
    {
        if ($this->Facture->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getOperation() === $this) {
                $facture->setOperation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): static
    {
        if (!$this->User->contains($user)) {
            $this->User->add($user);
            $user->setOperation($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->User->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getOperation() === $this) {
                $user->setOperation(null);
            }
        }

        return $this;
    }

    public function getDescriptionClient(): ?string
    {
        return $this->Description_client;
    }

    public function setDescriptionClient(string $Description_client): static
    {
        $this->Description_client = $Description_client;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->Img;
    }

    public function setImg(string $Img): static
    {
        $this->Img = $Img;

        return $this;
    }

    public function isValidationDemande(): ?bool
    {
        return $this->Validation_demande;
    }

    public function setValidationDemande(bool $Validation_demande): static
    {
        $this->Validation_demande = $Validation_demande;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

}


