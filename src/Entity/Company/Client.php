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
use App\Controller\Company\Client\StoreClientController;
use App\Controller\Company\Client\UpdateClientController;
use App\Controller\Typerice\StoreTypeRiceController;
use App\Controller\Typerice\TypeRiceController;
use App\Repository\Company\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    description: "Gestion des clients de notre application",
    normalizationContext: ['group' => ['read:client']],
    operations: [
        new Get(),
        new Post(
            denormalizationContext: ['group' => ['writte:client']],
            controller: StoreClientController::class,
        ),
        new Put(
            denormalizationContext: ['group' => ['writte:client']],
            controller: UpdateClientController::class
        ),
        new GetCollection(),
        new Delete()
    ]
)]

#[QueryParameter(
    key: 'name', property: 'name'
)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read:client')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('writte:client')]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('writte:client')]
    #[Assert\NotBlank]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Groups('writte:client')]
    #[Assert\NotBlank]
    private ?string $cin = null;

    #[ORM\Column(length: 255)]
    #[Groups('writte:client')]
    #[Assert\NotBlank]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    #[Groups('read:client')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups('read:client')]
    private ?\DateTimeImmutable $updatedAt = null;

    
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
}
