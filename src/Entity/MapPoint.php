<?php

namespace App\Entity;

use App\Repository\MapPointRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MapPointRepository::class)]
class MapPoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $Longitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $Latitude = null;

    #[ORM\ManyToOne(inversedBy: 'mapPoints')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MapPointsCategory $type = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    public function setLongitude(string $Longitude): static
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    public function setLatitude(string $Latitude): static
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getType(): ?MapPointsCategory
    {
        return $this->type;
    }

    public function setType(?MapPointsCategory $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
