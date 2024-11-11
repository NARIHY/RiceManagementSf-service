<?php

namespace App\Entity\Company;

use ApiPlatform\Doctrine\Orm\Filter\FilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\QueryParameter;
use App\Controller\Company\Client\GetOneClientController;
use App\Controller\Company\Client\StoreClientController;
use App\Controller\Company\Client\UpdateClientController;
use App\Entity\GenderManagement;
use App\Entity\User;
use App\Repository\Company\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    description: "Gestion des clients de notre application",
    normalizationContext:['groups' => ['client:collection:get', 'client:collection:post', 'client:collection:put','gender:collection:get']],
    operations: [
        new Get(            
            controller: GetOneClientController::class,
        ),
        new Post(
            denormalizationContext: ['groups' => ['client:collection:post','client:collection:put']],
            controller: StoreClientController::class,
        ),
        new Put(
            denormalizationContext: ['groups' => ['client:collection:put']],
            controller: UpdateClientController::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['client:collection:get', 'client:collection:post', 'client:collection:put','gender:collection:get']],
        ),
        new Delete()
    ],
   
)]

#[QueryParameter(
    key: 'name', property: 'name'
)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('client:collection:get')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('client:collection:post')]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('client:collection:post')]
    #[Assert\NotBlank]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Groups('client:collection:post')]
    #[Assert\NotBlank]
    private ?string $cin = null;

    #[ORM\Column(length: 255)]
    #[Groups('client:collection:put')]
    #[Assert\NotBlank]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    #[Groups('client:collection:get')]
    private ?GenderManagement $gender = null;

    #[ORM\OneToOne(inversedBy: 'client', cascade: ['persist', 'remove'])]
    #[Groups('client:collection:post')]
    private ?User $user = null;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    
    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getGender(): ?GenderManagement
    {
        return $this->gender;
    }

    public function setGender(?GenderManagement $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
