<?php

namespace App\Entity\Stock;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\Company\Stock\StoreBagController;
use App\Repository\Stock\BagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BagRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['bag:collection:get', 'bag:collection:post', 'arrival:collection:get', 'arrival:collection:post','stock:bag:collection']],
            denormalizationContext: ['groups' => ['bag:collection:post', 'bag:arrival:collection','stock:bag:collection']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['bag:collection:get', 'bag:collection:post', 'arrival:collection:get', 'arrival:collection:post','stock:bag:collection']],
            denormalizationContext: ['groups' => ['bag:collection:post', 'bag:arrival:collection','stock:bag:collection']]
        ),
        new Post(
            normalizationContext: ['groups' => ['bag:collection:get', 'bag:collection:post', 'arrival:collection:get', 'arrival:collection:post']],
            denormalizationContext: ['groups' => ['bag:collection:post']],
            controller: StoreBagController::class
        ),
        new Patch(
            normalizationContext: ['groups' => ['bag:collection:get', 'bag:collection:post', 'arrival:collection:get', 'arrival:collection:post']],
            denormalizationContext: ['groups' => ['bag:collection:post', 'bag:arrival:collection']]
        )
    ]
)
    
]
class Bag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('bag:collection:get')]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    #[Groups('bag:collection:post')]
    private ?string $quantity = null;

    /**
     * @var Collection<int, Arrival>
     */
    #[ORM\OneToMany(targetEntity: Arrival::class, mappedBy: 'bag')]
    #[Groups('bag:arrival:collection')]
    private Collection $arrivals;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    /**
     * @var Collection<int, Stock>
     */
    #[ORM\ManyToMany(targetEntity: Stock::class, inversedBy: 'Bag')]
    #[Groups('stock:bag:collection')]
    private Collection $stock;

    public function __construct()
    {
        $this->arrivals = new ArrayCollection();
        $this->stock = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): static
    {
        $this->quantity = $quantity;

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
            $arrival->setBag($this);
        }

        return $this;
    }

    public function removeArrival(Arrival $arrival): static
    {
        if ($this->arrivals->removeElement($arrival)) {
            // set the owning side to null (unless already changed)
            if ($arrival->getBag() === $this) {
                $arrival->setBag(null);
            }
        }

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

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        //
        $this->createdAt = new \DateTimeImmutable();
        $this->updateAt= new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updateAt = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, Stock>
     */
    public function getStock(): Collection
    {
        return $this->stock;
    }

    public function addStock(Stock $stock): static
    {
        if (!$this->stock->contains($stock)) {
            $this->stock->add($stock);
        }

        return $this;
    }

    public function removeStock(Stock $stock): static
    {
        $this->stock->removeElement($stock);

        return $this;
    }
}
