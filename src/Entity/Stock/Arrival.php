<?php

namespace App\Entity\Stock;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\Stock\ArrivalRepository;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArrivalRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['arrival:collection:get', 'arrival:collection:post', 'statuses:collection:get','statuses:collection:post','bag:collection:get','bag:collection:post']],
    operations: [
        new Get(),
        new GetCollection(), 
        new Patch(
            denormalizationContext: ['groups' => ['arrival:collection:post', 'status:collection:post']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['arrival:collection:post', 'status:collection:post']]
        )
    ]
)]
class Arrival
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('arrival:collection:get')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('arrival:collection:post')]
    private ?string $labelName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('arrival:collection:post')]
    private ?\DateTimeInterface $arrivalDate = null;

    #[ORM\ManyToOne(inversedBy: 'arrivals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('status:collection:post')]
    private ?Status $status = null;

    #[ORM\Column]
    #[Groups('arrival:collection:post')]
    private ?float $bagPrice = null;



    #[ORM\Column(nullable: true)]
    #[Groups('arrival:collection:get')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'arrivals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('arrival:collection:post')]
    private ?Bag $bag = null;

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabelName(): ?string
    {
        return $this->labelName;
    }

    public function setLabelName(string $labelName): static
    {
        $this->labelName = $labelName;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): static
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getBagPrice(): ?float
    {
        return $this->bagPrice;
    }

    public function setBagPrice(float $bagPrice): static
    {
        $this->bagPrice = $bagPrice;

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

    public function getBag(): ?Bag
    {
        return $this->bag;
    }

    public function setBag(?Bag $bag): static
    {
        $this->bag = $bag;

        return $this;
    }

   

    
}
