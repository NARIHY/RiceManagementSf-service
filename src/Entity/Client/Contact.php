<?php

namespace App\Entity\Client;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\Client\ContactPostController;
use App\Repository\Client\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            name: 'GetContact',
            normalizationContext: ['groups' => ['contact:collection:get', 'contact:collection:post']],
            denormalizationContext: ['groups' => ['contact:collection:post']],
        ),
        new GetCollection(
            name: 'GetContactCollection',
            normalizationContext: ['groups' => ['contact:collection:get', 'contact:collection:post']],
            denormalizationContext: ['groups' => [ 'contact:collection:post']]
        ),
        new Post(
            name:'PostContact',
            uriTemplate:'/user-contacts',
            normalizationContext: ['groups' => ['contact:collection:get', 'contact:collection:post']],
            denormalizationContext: ['groups' => ['contact:collection:post']],
            controller: ContactPostController::class
        )
    ]
)]
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    
    #[Groups('contact:collection:get')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('contact:collection:post')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('contact:collection:post')]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('contact:collection:post')]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('contact:collection:post')]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups('contact:collection:get')]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('contact:collection:post')]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('contact:collection:post')]
    private ?string $message = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
