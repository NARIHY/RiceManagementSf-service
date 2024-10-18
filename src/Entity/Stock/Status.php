<?php

namespace App\Entity\Stock;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\Stock\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['statuses:collection:get','statuses:collection:post']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['statuses:collection:get','statuses:collection:post']]
        ),
        new Post(
            normalizationContext: ['groups' => ['statuses:collection:get','statuses:collection:post']],
            denormalizationContext: ['groups' => ['statuses:collection:post']]
        ),
        new Patch(
            normalizationContext: ['groups' => ['statuses:collection:get','statuses:collection:post']],
            denormalizationContext: ['groups' => ['statuses:collection:post']]
        )
    ]
)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('statuses:collection:get')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups('statuses:collection:post')]
    private ?string $statusName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Arrival>
     */
    #[ORM\OneToMany(targetEntity: Arrival::class, mappedBy: 'status')]
    private Collection $arrivals;

    public function __construct()
    {
        $this->arrivals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusName(): ?string
    {
        return $this->statusName;
    }

    public function setStatusName(string $statusName): static
    {
        $this->statusName = $statusName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Arrival>
     */
    public function getArrivals(): Collection
    {
        return $this->arrivals;
    }

    public function addArrival(Arrival $arrival): static
    {
        if (!$this->arrivals->contains($arrival)) {
            $this->arrivals->add($arrival);
            $arrival->setStatus($this);
        }

        return $this;
    }

    public function removeArrival(Arrival $arrival): static
    {
        if ($this->arrivals->removeElement($arrival)) {
            // set the owning side to null (unless already changed)
            if ($arrival->getStatus() === $this) {
                $arrival->setStatus(null);
            }
        }

        return $this;
    }
    /**
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
