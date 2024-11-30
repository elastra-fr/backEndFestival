<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class MapPoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $mapPointId = null;

    #[ORM\ManyToOne(targetEntity: MapPointsCategory::class, inversedBy: 'mapPoints')]
    #[ORM\JoinColumn(name: "map_point_category_id", referencedColumnName: "map_point_category_id", nullable: false)]
    private ?MapPointsCategory $mapPointCategory = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 7)]
    private ?string $longitude = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 7)]
    private ?string $latitude = null;

    #[ORM\Column(length: 100)]
    private ?string $mapPointTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mapPointDescription = null;

    // Getter and Setter methods

    public function getMapPointId(): ?int
    {
        return $this->mapPointId;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getMapPointCategory(): ?MapPointsCategory
    {
        return $this->mapPointCategory;
    }

    public function setMapPointCategory(MapPointsCategory $mapPointsCategory): self
    {
        $this->mapPointCategory = $mapPointsCategory;
        return $this;
    }

    public function getMapPointTitle(): ?string
    {
        return $this->mapPointTitle;
    }

    public function setMapPointTitle(string $mapPointTitle): self
    {
        $this->mapPointTitle = $mapPointTitle;
        return $this;
    }

    public function getMapPointDescription(): ?string
    {
        return $this->mapPointDescription;
    }

    public function setMapPointDescription(?string $mapPointDescription): self
    {
        $this->mapPointDescription = $mapPointDescription;
        return $this;
    }
}
