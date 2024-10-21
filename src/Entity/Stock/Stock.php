<?php

namespace App\Entity\Stock;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\Stock\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection()
    ]
)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $aivalableQuantity = null;

    
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Bag>
     */
    #[ORM\ManyToMany(targetEntity: Bag::class, mappedBy: 'stock')]
    private Collection $bags;

    public function __construct()
    {
        $this->bags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAivalableQuantity(): ?string
    {
        return $this->aivalableQuantity;
    }

    public function setAivalableQuantity(string $aivalableQuantity): static
    {
        $this->aivalableQuantity = $aivalableQuantity;

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

    /**
     * @return Collection<int, Bag>
     */
    public function getBag(): Collection
    {
        return $this->bags;
    }

    public function addBag(Bag $bags): static
    {
        if (!$this->bags->contains($bags)) {
            $this->bags->add($bags);
            $bags->addStock($this);
        }

        return $this;
    }

    public function removeBag(Bag $bags): static
    {
        if ($this->bags->removeElement($bags)) {
            $bags->removeStock($this);
        }

        return $this;
    }

}
