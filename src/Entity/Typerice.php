<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TypericeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TypericeRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            name:'GetTypeRice',
            normalizationContext: ['groups' => ['typerice:collection:get', 'typerice:collection:post']]
        ),
        new GetCollection(
            name:'GetTypeRiceCollection',
            normalizationContext: ['groups' => ['typerice:collection:get', 'typerice:collection:post']]
        ),
        new Post(
            name:'SaveTypeRice',
            normalizationContext: ['groups' => ['typerice:collection:get', 'typerice:collection:post']],
            denormalizationContext: ['groups' => ['typerice:collection:post']]
        ),
        new Put(
            name:'UpdateTypeRice',
            normalizationContext: ['groups' => ['typerice:collection:get', 'typerice:collection:post']],
            denormalizationContext: ['groups' => ['typerice:collection:post']]
        ),
        new Delete(
            name:'DeleteTypeRice',
        )
    ]
)]
class Typerice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('typerice:collection:get')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups('typerice:collection:post')]
    private ?string $riceName = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups('typerice:collection:post')]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRiceName(): ?string
    {
        return $this->riceName;
    }

    public function setRiceName(string $riceName): static
    {
        $this->riceName = $riceName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
}
