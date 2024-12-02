<?php

namespace App\Entity\History;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\History\HistoriqueTempRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueTempRepository::class)]
#[ApiResource(
    uriTemplate: 'History/temp',
    operations: [
        new GetCollection(
            name:'HistoriquesCollection'
        )
    ]
)]
class HistoriqueTemp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomTable = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $action = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $details = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_action = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTable(): ?string
    {
        return $this->nomTable;
    }

    public function setNomTable(?string $nomTable): static
    {
        $this->nomTable = $nomTable;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getDateAction(): ?\DateTimeInterface
    {
        return $this->date_action;
    }

    public function setDateAction(?\DateTimeInterface $date_action): static
    {
        $this->date_action = $date_action;

        return $this;
    }
}
