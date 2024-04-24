<?php

namespace App\Entity;

use App\Repository\DemanderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemanderRepository::class)]
class Demander
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, operation>
     */
    #[ORM\ManyToMany(targetEntity: operation::class)]
    private Collection $operation;

    /**
     * @var Collection<int, client>
     */
    #[ORM\ManyToMany(targetEntity: client::class)]
    private Collection $client;

    #[ORM\Column(length: 500)]
    private ?string $discription_client = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    public function __construct()
    {
        $this->operation = new ArrayCollection();
        $this->client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, operation>
     */
    public function getOperation(): Collection
    {
        return $this->operation;
    }

    public function addOperation(operation $operation): static
    {
        if (!$this->operation->contains($operation)) {
            $this->operation->add($operation);
        }

        return $this;
    }

    public function removeOperation(operation $operation): static
    {
        $this->operation->removeElement($operation);

        return $this;
    }

    /**
     * @return Collection<int, client>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(client $client): static
    {
        if (!$this->client->contains($client)) {
            $this->client->add($client);
        }

        return $this;
    }

    public function removeClient(client $client): static
    {
        $this->client->removeElement($client);

        return $this;
    }

    public function getDiscriptionClient(): ?string
    {
        return $this->discription_client;
    }

    public function setDiscriptionClient(string $discription_client): static
    {
        $this->discription_client = $discription_client;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }
}
