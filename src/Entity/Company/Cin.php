<?php

namespace App\Entity\Company;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\Company\CinRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CinRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'cin:collection:get'],
    uriTemplate: '/cin',
    operations: [
        new GetCollection(
            name: 'GetCin',
        )
    ]
)]
class Cin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[Groups('cin:collection:get')]
    #[ORM\Column(length: 255)]
    private ?string $locationZone = null;

    #[Groups('cin:collection:get')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $locationRegion = null;

    #[Groups('cin:collection:get')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $locationProvince = null;

    #[Groups('cin:collection:get')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = 'Madagascar';

    #[ORM\OneToOne(mappedBy: 'cin_provenance', cascade: ['persist', 'remove'])]
    private ?Client $client = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postalCode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getLocationZone(): ?string
    {
        return $this->locationZone;
    }

    public function setLocationZone(string $locationZone): static
    {
        $this->locationZone = $locationZone;

        return $this;
    }

    public function getLocationRegion(): ?string
    {
        return $this->locationRegion;
    }

    public function setLocationRegion(?string $locationRegion): static
    {
        $this->locationRegion = $locationRegion;

        return $this;
    }

    public function getLocationProvince(): ?string
    {
        return $this->locationProvince;
    }

    public function setLocationProvince(?string $locationProvince): static
    {
        $this->locationProvince = $locationProvince;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        // unset the owning side of the relation if necessary
        if ($client === null && $this->client !== null) {
            $this->client->setCinProvenance(null);
        }

        // set the owning side of the relation if necessary
        if ($client !== null && $client->getCinProvenance() !== $this) {
            $client->setCinProvenance($this);
        }

        $this->client = $client;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }
}
